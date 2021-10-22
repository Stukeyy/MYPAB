<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Event;
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
    public function show(Event $event)
    {
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
            "start_date" => "required|string"
        ]);

        $event->update($validEvent);
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
