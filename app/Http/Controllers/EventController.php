<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Check;
use App\Models\Checklist;
use Illuminate\Http\Request;

use App\Http\Resources\EventResource;
use App\Http\Resources\TimetableResource;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // Returned to Full Calendar Plugin - needs to be formatted differently from Event Resource
        return response(TimetableResource::collection(Auth::user()->events), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Event $event)
    {   
        // type sent from frontend in order to return the correty resource type
        $type = $request->validate([
            "type" => "required|string"
        ]);

        return response(new EventResource($event), 200);
    }

    /**
     * This method is called via a separate route which is called when an
     * event is dragged and dropped on the Full Calendar plugin and its time is updated
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function updateTime(Request $request, Event $event)
    {   
        $newTimes = (object) $request->validate([
            'newStart' => 'required',
            'newEnd' => 'required'
        ]);

        $event->start_time = Carbon::parse($newTimes->newStart)->format('H:i');
        $event->end_time = Carbon::parse($newTimes->newEnd)->format('H:i');
        $event->start_date = Carbon::parse($newTimes->newStart)->format('d/m/Y');
        $event->end_date = Carbon::parse($newTimes->newEnd)->format('d/m/Y');
        // Isolated is set to true - still remains part of commitment but as it has isolated times - it will not be globally updated by commitment
        $event->isolated = true;
        $event->save();

        return response("Event Updated Successfully", 200);
    }

    /**
     * This method is called in apiResource which is called in Event Update Form
     * event is clicked on first and taken to separate form to update all event data not only time
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {

        // Updates whole Event Model not just time
        // Can also add Notes and Checklist here
        $validEvent = $request->validate([
            "name" => "required|string",
            "tag_id" => "required|integer|numeric",
            "start_time" => "required|string",
            "end_time" => "required|string",
            "start_date" => "required|string",
            "end_date" => "required|string",
            "notes" => "nullable",
            "checklist" => "nullable"
        ]);
        $updatedEvent = (object) $request->all();

        // Time formated in frontend to match time stored in backend - toLocaleDateString()
        $differentStartTime = ($updatedEvent->start_time !== $event->start_time);
        $differentEndTime = ($updatedEvent->end_time !== $event->end_time);
        // Start and End Date are same value - can only edit start date in update form and end date is set as same value
        $differentDate = ($updatedEvent->start_date !== $event->start_date);

        if($differentStartTime || $differentEndTime || $differentDate) {
            $event->update($validEvent);
            // If the updated event has a different time or date that the original values for the event - set isolated to true so it is not globally updatable by Commitment update
            $event->isolated = true;
            $event->save();
        } else {
            $event->update($validEvent);
        }

        $event->checks()->detach();
        foreach($updatedEvent->checklist as $check) {
            $check = Check::create([
                "check" => $check["value"],
                "completed" => false
            ]);
            $event->checks()->attach($check->id);
        }

        return response("Event Updated Successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
