<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Tag;
use App\Models\Event;
use App\Models\Activity;

use App\Http\Resources\TagResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TimetableResource;

class DashboardController extends Controller
{

    public function user(Request $request)
    {
        return response([
            'user' => $request->user()
        ]);
    }

    public function dashboardEvents(Request $request)
    {
        // Returned to Full Calendar Plugin - needs to be formatted differently from Event Resource
        $userEvents = Auth::user()->events;
        $userTasks = Auth::user()->dated_tasks;
        $commitmentEvents = Auth::user()->commitment_events;
        $allEvents = $userEvents->concat($userTasks)->concat($commitmentEvents);
        return response(TimetableResource::collection($allEvents), 200);
    }

    public function dashboardTasks(Request $request)
    {
         // type sent from frontend in order to return the correct resource type
         $type = $request->validate([
            "type" => "required|string",
            "list" => "required|in:incomplete,completed"
        ]);

        if ($request['type'] === 'index') {
            if ($request['list'] === 'incomplete') {
                return response(TaskResource::collection(Auth::user()->incomplete_tasks), 200);
            }
            else if ($request['list'] === 'completed') {
                return response(TaskResource::collection(Auth::user()->completed_tasks), 200);
            }
        }

    }

}
