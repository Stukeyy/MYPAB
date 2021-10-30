<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use App\Models\Event;
use App\Models\Commitment;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Http\Resources\CommitmentResource;
use App\Http\Resources\CommitmentCollection;

class CommitmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(new CommitmentCollection(Commitment::paginate(1)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        $validCommitment = $request->validate([
            "name" => "required|string",
            "tag_id" => "required|integer|numeric",
            "occurance" => "required|string",
            "day" => "requiredIf:occurance, !=, daily",
            "start_time" => "required|string",
            "end_time" => "required|string",
            "start_date" => "required|string",
            "end_date" => "required|string",
        ]);
        $validCommitment["user_id"] = Auth::id();
        $newCommitment = Commitment::create($validCommitment);
        $validCommitment['id'] = $newCommitment->id;

        $this->createEvents($validCommitment);
        
        return response('Commitment Added Successfully', 200);
    }

    /**
     * Creates events based on the commitment time and duration.
     *
     * @param  \App\Models\Commitment  $commitment
     * @return
    */
    public function createEvents(Array $validCommitment) {

        $commitment =  Commitment::find($validCommitment['id']);

        // Commitment range
        $start_date = Carbon::createFromFormat('d/m/Y', $commitment->start_date);
        $end_date = Carbon::createFromFormat('d/m/Y', $commitment->end_date);
        $period = CarbonPeriod::create($start_date, $end_date);

        // If the commitment occurs daily add every day in the commitment range to the events array
        if ($commitment->occurance === 'daily') {
            $events = [];
            foreach ($period as $date) {
                $events[] = $date->format('d/m/Y');
            }
        }
        // If the commitment doesnt occur daily set the start date to the recurring day set after the start of the commitment range and get each recurring instance of commitment based on frequency
        // e.g. set to first wednesday after 18/10/2021 - based on commitment day and commitment start and then get recurring instance of selected day and frequency
        else {
            $start_date = $this->getStartDate($commitment->day, $period);
            $events = $this->getEventDates($commitment->day, $commitment->occurance, $start_date, $commitment->end_date);
        }

        foreach($events as $event) {
            // Update event data to reflect single instance of commitment with id and new individual dates
            $validCommitment["commitment_id"] = $commitment->id;
            $validCommitment["start_date"] = $event;
            $validCommitment["end_date"] = $event;
            // isolated is set to true if event is individually updated - no longer globally updated by commitment
            $validCommitment["isolated"] = false;
            $event = Event::create($validCommitment);
            $commitment->events()->attach($event->id);
        }

        // return
    }

    // Gets the date of the selected recurring day of the commitment e.g. first wednesday in range..
    public function getStartDate(String $day, Object $period) {

        // Will go through each day in commitment range and return the first date that matches the selected day of the recurring commitment
        foreach ($period as $date) {
            if ($date->format('l') === ucfirst($day)) {
                return $date->format('d/m/Y');
            }
        }

    }

    // Gets all recurring events of the commitment range e.g. every wednesday each week between oct and dec...
    public function getEventDates(String $day, String $occurance, String $start_date, String $end_date) {

        $events = [];
        // Add new start date to events array set on the selected day of the commitment after the start date of the range
        $events[] = $start_date;

        $start_date = Carbon::createFromFormat('d/m/Y', $start_date);
        $end_date = Carbon::createFromFormat('d/m/Y', $end_date);

        // Get the next event of the commitment based on its occurance added to the selected day of the commitment after the start date of the range
        while ($start_date->lte($end_date)) {
            switch($occurance) {
                case 'weekly':
                    $start_date = $start_date->addWeek();
                    break;
                case 'fortnightly':
                    $start_date = $start_date->addWeeks(2);
                    break;
                case 'monthly':
                    $start_date = $start_date->addMonth();
                    break;
            }

            // If the date is before the end date of the commitment range add to the events array
            if ($start_date->lte($end_date)) {
                $events[] = $start_date->format('d/m/Y');
            }
        }
        return $events;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commitment  $commitment
     * @return \Illuminate\Http\Response
     */
    public function show(Commitment $commitment)
    {
        return response(new CommitmentResource($commitment), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commitment  $commitment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commitment $commitment)
    {
        // When updating commitment meta data - update all assoicated events
        // If the commitment time is being updated - only update events that arent isolated

        $validCommitment = $request->validate([
            "name" => "required|string",
            "tag_id" => "required|integer|numeric",
            "occurance" => "required|string",
            "day" => "requiredIf:occurance, !=, daily",
            "start_time" => "required|string",
            "end_time" => "required|string",
            "start_date" => "required|string",
            "end_date" => "required|string",
        ]);
        $validCommitment["user_id"] = Auth::id();
        $validCommitment["id"] = $commitment->id;

        $differentStartDate = ($validCommitment["start_date"] !== $commitment->start_date);
        $differentEndDate = ($validCommitment["end_date"] !== $commitment->end_date);
        $differentOccurance = ($validCommitment["occurance"] !== $commitment->occurance);
        $differentDay = ($validCommitment["day"] !== $commitment->day);

        // If commitment dates, occurance or day are different from original
        // delete all previous events and create new ones
        if ($differentStartDate || $differentEndDate || $differentOccurance || $differentDay) {
            // $commitment->delete(); Cascade delete not working?
            // BUG HERE
            $events = $commitment->events;
            foreach ($events as $event) {
                $event->delete();
            }
            $commitment->events()->detach();
            $this->createEvents($validCommitment);
        }
        else {
            $events = $commitment->events;

            foreach ($events as $event) {
                if ($event->isolated) {
                    // if the event has been updated separately and is isolated then only update name
                    $event->name = $validCommitment["name"];
                    $event->save();
                } else {
                    // if the event is the same as the commitment and not isolated - then update with new details
                    $event->update($validCommitment);
                    $event->end_date = $event->start_date;
                    $event->save();
                    // commitment events only occur across one day so reset end_date to start_date
                }
            }

        }

        // After checking update against original and updating events accordingly - update the commitment
        $commitment->update($validCommitment);

        return response('Commitment Updated Successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commitment  $commitment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commitment $commitment)
    {
        //
    }
}
