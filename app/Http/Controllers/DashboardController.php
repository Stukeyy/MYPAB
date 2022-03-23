<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Tag;
use App\Models\Event;
use App\Models\Activity;

use Carbon\Carbon;
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
        // only returns a users confirmed events, excludes currently suggested ones - should these be included for user to visualise?
        $userEvents = Auth::user()->events->where('suggested', false);
        $userTasks = Auth::user()->dated_tasks->where('suggested', false);
        $commitmentEvents = Auth::user()->commitment_events->where('suggested', false);
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

    public function dashboardBarChart(Request $request)
    {
        $xaxis = Auth::user()->tags->pluck('name');
        $bars = [];
        // bar format required for frontend echarts
        $bar = [
            "name" => '',
            "type" => 'bar',
            "barWidth" => '50%',
            "value" => 0,
            "animationDuration" => 3000,
            "itemStyle" => [
                "color" => 'red'
            ]
        ];

        // get all users tags
        $tags = Auth::user()->tags;
        foreach ($tags as $tag) {
            $bar["name"] = $tag->name;
            $bar["itemStyle"]["color"] = $tag->colour;
            $tagTime = 0;

            // get all tag events and tasks as well as their genesis parent - work or life
            $genesis = $tag->genesis();
            $events = $tag->events;
            $tasks = $tag->tasks;
            $allTagEvents = $events->concat($tasks);

            if($allTagEvents) {
                // get the amount of hours of each event and task for tag and add to total tag time
                foreach ($allTagEvents as $tagEvent) {
                    // will exclude all day events as well as tasks with a start time and no end time, also excludes currently suggested events
                    if ($tagEvent->start_time && $tagEvent->end_time && !$tagEvent->suggested) {
                        $from = Carbon::parse($tagEvent->start_time);
                        $to = Carbon::parse($tagEvent->end_time);
                        $diffInHours = $to->diffInHours($from);
                        $tagTime += $diffInHours;
                    }
                }
            }

            $bar["value"] = $tagTime;
            array_push($bars, $bar);

            // loops through all bars in the array and adds the total to the current tags genesis tag - work or life
            // so it appears as culmination of all its sub tags
            foreach($bars as $index => $bar) {
                if ($bar["name"] == $genesis->name) {
                    $bars[$index]["value"] += $tagTime;
                }
            }
        }

        $chartData = [
            "xaxis" => $xaxis,
            "bars" => $bars
        ];

        return response($chartData);
    }

}
