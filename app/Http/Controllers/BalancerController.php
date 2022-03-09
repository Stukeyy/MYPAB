<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
        if ($currentlyBalancing) {
            return response("Balancer Process Already Running", 409);
        } else {
            return response("No Balancer Running", 200);
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
        if ($currentlyBalancing) {
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
                $x = $this->balanceWeek();
                return response($x, 200);
                // return response("Balancer Started", 200);
            }
            catch(\Exception $e)
            {
                return response("Error Completing Balancer", 500);
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
        // throw new \ErrorException('Error');

        // UPDATE - the user should be able to set these themselves on profile page
        // add column to user table - deafult on register and can update on profile page
        // blocks of calendar options outside hours, new balance can only occur between them
        $businessHours = ((21 - 7) * 7); // currentlt 7am - 9pm Mon - Sun = 98 hours
        // return $businessHours;


        $weeklyCommitments = Auth::user()->weeklyCommitments;
        $weeklyEvents = Auth::user()->weeklyEvents;
        $weeklyTasks = Auth::user()->weeklyTasks;
        $week = $weeklyCommitments->concat($weeklyEvents)->concat($weeklyTasks);
        return $week;

        // split into work and life and then get time

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Balancer  $balancer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Balancer $balancer)
    {
        //
    }
}
