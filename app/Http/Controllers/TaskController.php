<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Check;
use App\Models\Job;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;

use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;

use App\Jobs\TestJob;
use App\Mail\TestMail;
use App\Jobs\GetJobID;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // type sent from frontend in order to return the correct resource type
        $type = $request->validate([
            "type" => "required|string",
            "list" => "required|in:incomplete,completed",
            "orderColumn" => "required",
            "tagFilter" => "required"
        ]);
        $orderColumn = $request->orderColumn;
        $tagFilter = $request->tagFilter;

        $totals = [
            "completedTotal" => Auth::user()->completed_tasks->count(),
            "incompleteTotal" => Auth::user()->incomplete_tasks->count(),
            "tasksTotal" => (Auth::user()->completed_tasks->count() + Auth::user()->incomplete_tasks->count())
        ];
        // totals added to request so they are accessible in resource
        $request["totals"] = $totals;

        // tags added to request so they are accessible in resource
        $taskTags = $this->getTaskTags();
        $request["tags"] = $taskTags;

        if ($request['type'] === 'index') {
            if ($request['list'] === 'incomplete') {
                return response(new TaskCollection(Auth::user()->incomplete_tasks($orderColumn, $tagFilter)->paginate(10)->appends(request()->query())), 200);
            }
            else if ($request['list'] === 'completed') {
                return response(new TaskCollection(Auth::user()->completed_tasks($orderColumn, $tagFilter)->paginate(10)->appends(request()->query())), 200);
            }
        }
    }

    // returns array of tag IDs for the completed tasks as well as incomplete tasks to show separate selector values for each list tagFilter in frontend
    public function getTaskTags() {
        $incompleteTaskTags = Auth::user()->incomplete_tasks->pluck('tag_id');
        $incompleteTags = Tag::whereIn('id', $incompleteTaskTags)->get();
        $completedTaskTags = Auth::user()->completed_tasks->pluck('tag_id');
        $completedTags = Tag::whereIn('id', $completedTaskTags)->get();
        return [
            "incompleteTags" => $incompleteTags,
            "completedTags" => $completedTags
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validTask = $request->validate([
            "task" => "required|string",
            "tag_id" => "required|integer|numeric",
            "priority" => "required|in:low,medium,high",
            "start_date" => "nullable|string",
            "start_time" => "nullable|string",
            "end_time" => "nullable|string",
            "reminders" => "nullable",
            "notes" => "nullable",
            "checklist" => "nullable"
        ]);
        $validTask['user_id'] = Auth::id();
        $validTask['suggested'] = false;
        $validTask['completed'] = false;
        $validTask['all_day'] = false;
        $newTask = (object) $request->all();

        // return response($request->all());

        // format date
        if(isset($validTask['start_date'])) {
            $validTask['start_date'] = Carbon::createFromFormat('d/m/Y', $validTask['start_date'])->format('d/m/Y');
            // if date selected but no time - set as all day
            if(isset($validTask['start_date']) && !isset($validTask['start_time'])) {
                $validTask['all_day'] = true;
            }
        }

        $task = Task::create($validTask);

        // Adds checks to DB and assigns to current task
        foreach($newTask->checklist as $check) {
            $check = Check::create([
                "task_id" => $task->id,
                "check" => $check["value"],
                "completed" => false
            ]);
            $task->checks()->attach($check->id);
        }
        Auth::user()->tasks()->attach($task->id);

        // Dispatches Task Reminder Jobs and also creates Reminders with their assoicated Job IDs
        if(isset($validTask['reminders'])) {
            foreach($validTask['reminders'] as $reminder) {
                $reminder_date_carbon_format = Carbon::createFromFormat('d/m/Y', $reminder['date']);
                $reminder_time_carbon_format = Carbon::createFromFormat('H:i', $reminder['time']);
                $reminder_carbon_format = Carbon::createFromFormat('d/m/Y H:i', $reminder['date'] . ' ' . $reminder['time']);
                TestJob::dispatch($task)->delay($reminder_carbon_format);
                $this->attachJobIDsToReminders($task, $reminder_date_carbon_format, $reminder_time_carbon_format);
            }
        }

        return response('Task Added Successfully', 200);
    }


    // When a job is created, even if delayed and inserted to jobs table, you can only access it within the handle method
    // the handle method is only run when the job is being executed, even if delayed
    // this is a workaround to get the Job IDs related to the Task Reminders
    public function attachJobIDsToReminders(Task $task, $reminderDate, $reminderTime) {

        // Get all jobs created within last hour
        // This will include the Job created for each Task Reminder set
        // Set within last hour incase other users also submit Tasks with Reminders
        // This ensures that specific Task Reminder jobs will be present without obtaining whole Jobs collection
        $withinLastHour = Carbon::now()->subHour()->timestamp;
        $jobs = Job::where('created_at', '>', $withinLastHour)->get();

        foreach($jobs as $job) {
            // Job data is serialized and stored as payload when Job is created
            // Need to decode and unserialize data to access
            $jobPayload = json_decode($job->payload);
            $jobData = unserialize($jobPayload->data->command);
            $jobTaskID = json_encode($jobData->task->id);
            $jobTaskID = intval($jobTaskID);

            // Task Model is attached to Job via constructor method during dispatch
            // Check to see if the Jobs associated Task matches the current Task
            // If it does, then this is the Job ID associated with the Tasks Reminder
            if ($jobTaskID === $task->id) {
                // If Task has multiple Reminders, then multiple Jobs will be created for each Task Reminder
                // As all still associated to the same Task, can result in duplicate Reminders being created
                // First Or Create will ensure that there are no duplicates based on Job ID
                $reminder = Reminder::firstOrCreate(
                    [
                        'job_id' => $job->id
                    ],
                    [
                        'user_id' => Auth::user()->id,
                        'task_id' => $task->id,
                        'job_id' => $job->id,
                        'date_to_send' => $reminderDate,
                        'time_to_send' => $reminderTime
                    ]
                );
            }

        }

    }

    // Called when clicking complete button on tasks table
    public function completeTask(Task $task)
    {
        $task->completed = !$task->completed;
        $task->save();

        return response("Task Updated Successfully", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Task $task)
    {
        // type sent from frontend in order to return the correty resource type
        $type = $request->validate([
            "type" => "required|string"
        ]);

        return response(new TaskResource($task), 200);
    }

    /**
     * This method is called via a separate route which is called when an
     * task is dragged and dropped on the Full Calendar plugin and its time is updated
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function updateTime(Request $request, Task $task)
    {
        $newTimes = (object) $request->validate([
            'allDay' => 'boolean|required',
            'newStart' => 'requiredIf:allDay,==,false',
            'newEnd' => 'nullable|string'
        ]);

        // If task is set to all day - null times
        if ($newTimes->allDay) {
            $task->start_date = Carbon::parse($newTimes->newStart)->format('d/m/Y');
            $task->start_time = null;
            $task->end_time = null;
            $task->all_day = true;
        // If task is not set to all day - set start date and start time - end time is not required
        } else {
            $task->start_date = Carbon::parse($newTimes->newStart)->format('d/m/Y');
            $task->start_time = Carbon::parse($newTimes->newStart)->format('H:i');
            // if end time provided then set as end time - but not required
            if ($newTimes->newEnd !== null) {
                $task->end_time = Carbon::parse($newTimes->newEnd)->format('H:i');
            } else {
                $task->end_time = null;
            }
            $task->all_day = false;
        }

        // If date or time have been changed then remove all previous reminders and jobs
        $reminders = $task->reminders;
        foreach ($reminders as $reminder) {
            $originalReminder = Reminder::find($reminder["id"]);
            // If original reminder is found, then an associated job will exist, this will delete both the job and the reminder
            if ($originalReminder) {
                Job::destroy($originalReminder["job_id"]);
                Reminder::destroy($originalReminder["id"]);
            }
        }

        $task->save();

        return response("Task Updated Successfully", 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        // Updates whole Task Model not just time
        // Can also add Notes and Checklist here
        $validTask = $request->validate([
            "task" => "required|string",
            "tag_id" => "required|integer|numeric",
            "priority" => "required|in:low,medium,high",
            "start_date" => "nullable|string",
            "start_time" => "nullable|string",
            "end_time" => "nullable|string",
            "reminders" => "nullable",
            "notes" => "nullable",
            "checklist" => "nullable"
        ]);
        $validTask['all_day'] = false;
        $updatedTask = (object) $request->all();

        // format date
        if(isset($validTask['start_date'])) {
            $validTask['start_date'] = Carbon::createFromFormat('d/m/Y', $validTask['start_date'])->format('d/m/Y');
            // if date selected but no time - set as all day
            if(isset($validTask['start_date']) && !isset($validTask['start_time'])) {
                $validTask['all_day'] = true;
            }
        }

        $task->update($validTask);

        $task->checks()->detach();
        foreach($updatedTask->checklist as $check) {
            // checks are deleted and dettached from pivot table but not from original checks table
            // this will check if any updated checks already exist in checks table and if true - deletes before creating again
            if (isset($check["id"])) {
                Check::destroy($check["id"]);
            }
            $check = Check::create([
                "task_id" => $task->id,
                "check" => $check["value"],
                "completed" => $check["completed"]
            ]);
            $task->checks()->attach($check->id);
        }

        // Reminders
        $updatedReminderIDs = [];
        $originalReminderIDs = $task->reminders->pluck('id')->toArray();
        foreach($updatedTask->reminders as $reminder) {
            // Loops through all reminders returned from update form, if they are assoicated with existing reminders via an ID
            // then the associated job is deleted as well as the reminder itself and new ones are generated

            if (isset($reminder["id"])) {
                array_push($updatedReminderIDs, $reminder["id"]);
            }

            // New reminders created in frontend update form will not have ID
            // Only existing reminders made in add form and returned from backend to update form will have an ID
            if (isset($reminder["id"])) {
                $originalReminder = Reminder::find($reminder["id"]);
                // If original reminder is found, then an associated job will exist, this will delete both the job and the reminder
                if ($originalReminder) {
                    Job::destroy($originalReminder["job_id"]);
                    Reminder::destroy($originalReminder["id"]);
                }
            }

            // Dispatches New Task Reminder Jobs and also creates New Reminders with their assoicated New Job IDs
            $reminder_date_carbon_format = Carbon::createFromFormat('d/m/Y', $reminder['date']);
            $reminder_time_carbon_format = Carbon::createFromFormat('H:i', $reminder['time']);
            $reminder_carbon_format = Carbon::createFromFormat('d/m/Y H:i', $reminder['date'] . ' ' . $reminder['time']);
            TestJob::dispatch($task)->delay($reminder_carbon_format);
            $this->attachJobIDsToReminders($task, $reminder_date_carbon_format, $reminder_time_carbon_format);
        }

        // If an existing reminder is deleted in frontend update form, it will not exist in request
        // all the original IDs are then compared with the new update IDs and if any are missing, then they are deleted as well as their associated job
        $remindersRemovedInUpdate = array_diff($originalReminderIDs, $updatedReminderIDs);
        foreach ($remindersRemovedInUpdate as $removedReminderID) {
            $originalReminder = Reminder::find($removedReminderID);
            // If original reminder is found, then an associated job will exist, this will delete both the job and the reminder
            if ($originalReminder) {
                Job::destroy($originalReminder["job_id"]);
                Reminder::destroy($originalReminder["id"]);
            }
        }

        $task->save();

        return response("Task Updated Successfully", 200);
    }

    // Called on View Task Page when X is clicked beside reminder
    // Will delete the specific reminder and its associated job
    public function deleteReminder(Reminder $reminder) {
        Job::destroy($reminder->id);
        $reminder->delete();
        return response("Reminder and Job Deleted Successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        // deletes checks from original checks table
        foreach($task->checks as $check) {
            Check::destroy($check["id"]);
        }
        // deletes checks from pivot table
        $task->checks()->detach();

        // deletes the tasks reminders and their associated jobs
        $reminders = $task->reminders;
        foreach ($reminders as $reminder) {
            $originalReminder = Reminder::find($reminder["id"]);
            // If original reminder is found, then an associated job will exist, this will delete both the job and the reminder
            if ($originalReminder) {
                Job::destroy($originalReminder["job_id"]);
                Reminder::destroy($originalReminder["id"]);
            }
        }

        $task->delete();
        return response("Task Deleted Successfully", 200);
    }
}
