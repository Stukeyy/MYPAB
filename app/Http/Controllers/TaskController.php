<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Check;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;

use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;

use App\Mail\TestMail;
use App\Jobs\TestJob;

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
            "notes" => "nullable",
            "checklist" => "nullable"
        ]);
        $validTask['user_id'] = Auth::id();
        $validTask['suggested'] = false;
        $validTask['completed'] = false;
        $validTask['all_day'] = false;
        $newTask = (object) $request->all();

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

        // Auth::user()->email
        // Mail::to("stephenr.ross@yahoo.com")->send(new TestMail());

        // NEED TO RESTART QUEUE AFTER ANY JOB CHANGES
        // php artisan queue:listen --timeout=0
        // May need to add queue to start up script in term2
        // Can pass in this format to delay - "2022-07-02T19:26:33.055251Z"
        TestJob::dispatch()->delay(now()->addMinutes(1));
        return response('Task Added Successfully', 200);
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

        $task->save();

        return response("Task Updated Successfully", 200);
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
        $task->delete();
        return response("Task Deleted Successfully", 200);
    }
}
