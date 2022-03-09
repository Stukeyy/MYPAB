<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Event;
use App\Models\Balancer;
use Illuminate\Http\Request;

class BalancerController extends Controller
{

    /**
     * Checks if user already has a balancer running
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function currentlyBalancing(Request $request)
    {
        $currentlyBalancing = Auth::user()->currentlyBalancing->last();
        // if no existing balancers found or the users last balancer is complete then return success
        if (!$currentlyBalancing || $currentlyBalancing->completed) {
            return response("No Balancer Running", 200);
        } else {
            // If user has a balancer currently open then return error
            return response("Balancer Process Already Running", 409);
        }
    }

    /**
     * Checks if user already has a balancer running
     * and if not, will start a new one
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newBalance(Request $request)
    {
        // currently balancing method called on mounted and if running will disable the balancer button
        // if the user goes into elements to enable and send a new balance request, this will check again
        $currentlyBalancing = Auth::user()->currentlyBalancing->last();
        // If user has a balancer currently open then return error
        if ($currentlyBalancing && !$currentlyBalancing->completed) {
            return response("Balancer Process Already Running", 409);
        } else {

            // $balancer = new Balancer;
            // $balancer->user_id = Auth::user()->id;
            // $balancer->completed = false;
            // $balancer->save();

            try
            {
                // balance week must be done now rather than via a queued job
                // as any new commitments, events, tasks or tag updates will affect balance
                return $this->balanceWeek();

                // $balancer->completed = true;
                // $balancer->save();

                return response("Week Balanced", 200);
            }
            catch(\Exception $error)
            {
                return response($error, 500);
            }

        }
    }

    /**
     *
     *
     *
     *
    */
    private function balanceWeek() {

        $workLife = ["work", "life"];
        $balanceHours = $this->balanceHours();
        $workBalanceRemaining = $balanceHours["workBalanceRemaining"];
        $lifeBalanceRemaining = $balanceHours["lifeBalanceRemaining"];
        $allWeeklyEvents = $balanceHours["allWeeklyEvents"];

        // tasks need to be keyed by object ID so that once set
        // they can be pulled from original collection so no duplicates can be made
        // activities on other hand can be duplicated
        $workTasks = Auth::user()->suggestedWorkTasks->keyBy('id');
        $lifeTasks = Auth::user()->suggestedlifeTasks->keyBy('id');
        $workActivities = Auth::user()->suggestedWorkActivities->toArray();
        $lifeActivities = Auth::user()->suggestedLifeActivities->toArray();
        $prep = [
            "workBalanceRemaining" => $workBalanceRemaining,
            "workTasks" => $workTasks,
            "workActivities" => $workActivities,
            "lifeBalanceRemaining" => $lifeBalanceRemaining,
            "lifeTasks" => $lifeTasks,
            "lifeActivities" => $lifeActivities
        ];

        $week = Auth::user()->week();
        foreach($workLife as $wife) {
            // reduced amount as week looked very cluttered - 25%
            for($x = 0; $x <= ($prep[$wife . "BalanceRemaining"] / 2); $x++) {
                $randomDate = $week[array_rand($week)];
                // $businessHours = ((21 - 7) * 7); // THIS WILL NEED UPDATED TO USER BUSINESS HOURS
                // each new suggested event will be 1 hour so dont take last hour
                $hour = rand(7, 20);
                // if hour below 10 e.g 7, then pad with 0 e.g. 07:00, then add an hour for the end time
                $randomStartTime = ($hour < 10) ? "0" . $hour . ":00" : $hour . ":00";
                $randomEndTime = (($hour + 1) < 10) ? "0" . ($hour + 1) . ":00" : ($hour + 1) . ":00";

                $conflict = false;
                foreach($allWeeklyEvents as $event) {
                    if ($event->start_date == $randomDate && ($event->start_time == $randomStartTime || $event->end_time == $randomEndTime)) {
                        $conflict = true;
                        break;
                    }
                }

                if ($conflict) {
                    continue;
                } else {
                    if (count($prep[$wife . "Tasks"]) > 0) {
                        $prioritisedTask = $prep[$wife . "Tasks"]->first();
                        $event = $this->createEvent($prioritisedTask["task"], $prioritisedTask["tag_id"], $randomStartTime, $randomEndTime, $randomDate);
                        $prep[$wife . "Tasks"]->pull($prioritisedTask->id);
                    } else if (count($prep[$wife . "Tasks"]) == 0 && count($prep[$wife . "Activities"]) > 0) {
                        // need to always make sure there are at least some work activities to choose from - user cant delete all
                        // similar to work and life but dont show user
                        $randomWorkActivity = $prep[$wife . "Activities"][array_rand($prep[$wife . "Activities"])];
                        $event = $this->createEvent($randomWorkActivity["name"], $randomWorkActivity["tag_id"], $randomStartTime, $randomEndTime, $randomDate);

                    }
                }

                // need to push new event to week so that no conflicts are added
                $allWeeklyEvents->push($event);
                Auth::user()->events()->attach($event->id);

            }

        }

        return "Success";

    }

    public function balanceHours()
    {
        // UPDATE - the user should be able to set these themselves on profile page
        // add column to user table - deafult on register and can update on profile page
        // blocks of calendar options outside hours, new balance can only occur between them
        $businessHours = ((21 - 7) * 7); // currently 7am - 9pm Mon - Sun = 98 hours
        $halfOfBusinessHours = $businessHours / 2;

        $weeklyCommitments = Auth::user()->weeklyCommitments;
        $weeklyEvents = Auth::user()->weeklyEvents;
        $weeklyTasks = Auth::user()->weeklyTasks;
        $allWeeklyEvents = $weeklyCommitments->concat($weeklyEvents)->concat($weeklyTasks);

        $currentWorkHours = 0;
        $currentLifeHours = 0;
        foreach($allWeeklyEvents as $event) {
            $genesis = $event->tag->genesis();
            // will exclude all day events as well as tasks with a start time and no end time
            if ($event->start_time && $event->end_time) {
                $from = Carbon::parse($event->start_time);
                $to = Carbon::parse($event->end_time);
                $diffInHours = $to->diffInHours($from);
                if ($genesis->name == "Work") {
                    $currentWorkHours += $diffInHours;
                }
                else if ($genesis->name == "Life") {
                    $currentLifeHours += $diffInHours;
                }
            }
        }

        $workBalanceRemaining = round($halfOfBusinessHours - $currentWorkHours);
        $lifeBalanceRemaining = round($halfOfBusinessHours - $currentWorkHours);
        $balanceHours = [
            "workBalanceRemaining" => $workBalanceRemaining,
            "lifeBalanceRemaining" => $lifeBalanceRemaining,
            "allWeeklyEvents" => $allWeeklyEvents
        ];

        return $balanceHours;
    }

    public function createEvent(String $name, Int $tagID, String $randomStartTime, String $randomEndTime, String $randomDate)
    {
        $event = new Event;
        $event->name = $name;
        $event->user_id = Auth::user()->id;
        $event->tag_id = $tagID;
        $event->start_time = $randomStartTime;
        $event->end_time = $randomEndTime;
        $event->start_date = $randomDate;
        $event->end_date = $randomDate;
        $event->all_day = false;
        $event->isolated = true;
        $event->suggested = true;
        $event->save();

        return $event;
    }

}
