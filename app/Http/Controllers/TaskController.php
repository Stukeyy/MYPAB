<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Task;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;

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
            "list" => "required|in:incomplete,completed"
        ]);

        if ($request['type'] === 'index') {
            if ($request['list'] === 'incomplete') {
                return response(new TaskCollection(Auth::user()->incomplete_tasks()->paginate(1)->appends(request()->query())), 200);

            }
            else if ($request['list'] === 'completed') {
                return response(new TaskCollection(Auth::user()->completed_tasks()->paginate(3)->appends(request()->query())), 200);
            }
        }
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
            "end_time" => "nullable|string"
        ]);
        $validTask['user_id'] = Auth::id();
        $validTask['completed'] = false;
        $validTask['all_day'] = false;

        // format date
        if(isset($validTask['start_date'])) {
            $validTask['start_date'] = Carbon::createFromFormat('d/m/Y', $validTask['start_date'])->format('d/m/Y');
            // if date selected but no time - set as all day
            if(isset($validTask['start_date']) && !isset($validTask['start_time'])) {
                $validTask['all_day'] = true;
            }
        }

        $task = Task::create($validTask);
        Auth::user()->tasks()->attach($task->id);

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

        if ($newTimes->allDay) {
            $task->start_date = Carbon::parse($newTimes->newStart)->format('d/m/Y');
            $task->start_time = null;
            $task->end_time = null;
            $task->all_day = true;
        } else {
            $task->start_time = Carbon::parse($newTimes->newStart)->format('H:i');
            if ($newTimes->newEnd !== null) {
                $task->end_time = Carbon::parse($newTimes->newEnd)->format('H:i');    
            } else {
                $task->end_time = null;
            }
            $task->start_date = Carbon::parse($newTimes->newStart)->format('d/m/Y');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response("Task Deleted Successfully", 200);
    }
}
