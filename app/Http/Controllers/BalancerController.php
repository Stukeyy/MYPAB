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
     * balancer is only stopped when the user has confirmed all of the suggestions made
     *
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
        // if the user goes into console to enable and send a new balance request, this will check again
        $currentlyBalancing = Auth::user()->currentlyBalancing->last();
        // If user has a balancer currently open then return error
        if ($currentlyBalancing && !$currentlyBalancing->completed) {
            return response("Balancer Process Already Running", 409);
        } else {

            $balancer = new Balancer;
            $balancer->user_id = Auth::user()->id;
            $balancer->completed = false;
            $balancer->save();

            try
            {
                // balance week must be done now rather than via a queued job
                // as any new commitments, events, tasks or tag updates will affect balance
                $this->balanceWeek();
                return response("Week Balanced", 200);
            }
            catch(\Exception $error)
            {
                return response($error, 500);
            }

        }
    }

    /**
     * Will populate the current week with all of the users priority tasks
     * then for the remainder will populate with activities acording to required tag balance
     *
    */
    private function balanceWeek() {

        // balanceWeek will loop through both work and life
        $workLife = ["work", "life"];
        // gets the hours required for both work and life to balance the week
        $balanceHours = $this->balanceHours();
        $workBalanceRemaining = $balanceHours["workBalanceRemaining"];
        $lifeBalanceRemaining = $balanceHours["lifeBalanceRemaining"];
        $allWeeklyEvents = $balanceHours["allWeeklyEvents"];
        // Gets an array of the current week dates
        $week = Auth::user()->week();

        // tasks need to be keyed by object ID so that once set they can be pulled from original collection so no duplicates can be made
        // activities on other hand can be duplicated
        $workTasks = Auth::user()->suggestedWorkTasks->keyBy('id');
        $lifeTasks = Auth::user()->suggestedlifeTasks->keyBy('id');
        $workActivities = Auth::user()->suggestedWorkActivities->toArray();
        $lifeActivities = Auth::user()->suggestedLifeActivities->toArray();
        // VERY IMPORTANT KEYS ARE KEPT CONSISTANT BETWEEN PREP AND WORKLIFE FOR LOOPING
        $prep = [
            "workBalanceRemaining" => $workBalanceRemaining,
            "workTasks" => $workTasks,
            "workActivities" => $workActivities,
            "lifeBalanceRemaining" => $lifeBalanceRemaining,
            "lifeTasks" => $lifeTasks,
            "lifeActivities" => $lifeActivities
        ];

        foreach($workLife as $wife) {
            // reduced amount as of events generate as week looked very cluttered - 25%
            for($x = 0; $x <= ($prep[$wife . "BalanceRemaining"] / 2); $x++) {
                $randomDate = $week[array_rand($week)];
                // $businessHours = ((21 - 7) * 7); // THIS WILL NEED UPDATED TO USER BUSINESS HOURS
                // each new suggested event will be 1 hour so dont take last hour
                $hour = rand(7, 20);
                // if hour below 10 e.g 7, then pad with 0 e.g. 07:00, then add an hour for the end time
                $randomStartTime = ($hour < 10) ? "0" . $hour . ":00" : $hour . ":00";
                $randomEndTime = (($hour + 1) < 10) ? "0" . ($hour + 1) . ":00" : ($hour + 1) . ":00";

                $conflict = false;
                // checks through all current events for the week (even the new ones which are generate and added) and if any conflicts, will reloop
                foreach($allWeeklyEvents as $event) {
                    if ($event->start_date == $randomDate && ($event->start_time == $randomStartTime || $event->end_time == $randomEndTime)) {
                        $conflict = true;
                        break;
                    }
                }

                // any conflicts reloop
                if ($conflict) {
                    continue;
                } else {
                    // TASKS ARE ORDERED IN RELATIONSHIP TO BE RETURNED IN PRIORITY ORDER - HIGH, MEDIUM, LOW
                    if (count($prep[$wife . "Tasks"]) > 0) {
                        // top task prioritised picked
                        $prioritisedTask = $prep[$wife . "Tasks"]->first();
                        // event created from task selected
                        $event = $this->createEvent($prioritisedTask["task"], $prioritisedTask["tag_id"], $randomStartTime, $randomEndTime, $randomDate);
                        // task removed from array so next priority is picked and no duplicates made
                        $prep[$wife . "Tasks"]->pull($prioritisedTask->id);
                    // AFTER ALL TASKS CREATED THEN MOVE ONTO ACTIVITIES
                    } else if (count($prep[$wife . "Tasks"]) == 0 && count($prep[$wife . "Activities"]) > 0) {
                        // need to always make sure there are at least some work activities to choose from - user cant delete all - similar to work and life but dont show user
                        $randomWorkActivity = $prep[$wife . "Activities"][array_rand($prep[$wife . "Activities"])];
                        $event = $this->createEvent($randomWorkActivity["name"], $randomWorkActivity["tag_id"], $randomStartTime, $randomEndTime, $randomDate);

                    }
                }

                // need to push new event to allWeeklyEvents so that any new events will not conflict with exsisting ones
                $allWeeklyEvents->push($event);
                Auth::user()->events()->attach($event->id);

            }

        }

        return "Success";

    }

    // Returns the hours required for work and life in order to be balanced - used to generate the appropriate amount of each tags events
    public function balanceHours()
    {
        // UPDATE - the user should be able to set these themselves on profile page
        // add column to user table - deafult 7 - 9 on register and can update on profile page
        // blocks off calendar options outside business hours, new balance events can only occur between them
        $businessHours = ((21 - 7) * 7); // currently 7am - 9pm Mon - Sun = 98 hours
        $halfOfBusinessHours = $businessHours / 2; // 49 hours work 49 hours life - CLUTTERED - HALVED AGAIN DURING EVENT GENERATION

        // returns only the commitments, events and tasks of CURRENT WEEK
        $weeklyCommitments = Auth::user()->weeklyCommitments;
        $weeklyEvents = Auth::user()->weeklyEvents;
        $weeklyTasks = Auth::user()->weeklyTasks;
        $allWeeklyEvents = $weeklyCommitments->concat($weeklyEvents)->concat($weeklyTasks);

        $currentWorkHours = 0;
        $currentLifeHours = 0;
        // loops through each event of the CURRENT week and adds total time to related genesis tag
        foreach($allWeeklyEvents as $event) {
            // genesis will either be Work or Life
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

    // creates an event with the given task or activity passed
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

    // confirms each suggested event which is clicked on by user in the frontend
    public function confirmSuggestion(Event $event) {
        $event->suggested = false;
        $event->save();
        return response("Suggestion Confirmed Successfully", 200);
    }

    public function finishBalance() {

        // Deletes all suggested events which were not confirmed by user on frontend
        $events = Auth::user()->events;
        foreach($events as $event) {
            if ($event->suggested) {
                $event->delete();
            }
        }

        // finishes balancer
        $currentlyBalancing = Auth::user()->currentlyBalancing->last();
        $currentlyBalancing->completed = true;
        $currentlyBalancing->save();

        return response("All Suggestions Confirmed", 200);
    }

}
