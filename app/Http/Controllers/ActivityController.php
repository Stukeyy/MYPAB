<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\Activity;

use App\Http\Resources\ActivityResource;
use App\Http\Resources\ActivityCollection;

class ActivityController extends Controller
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
            "type" => "required|string"
        ]);

        if ($request['type'] === 'table') {
            // activities paginated for activity table
            return response(new ActivityCollection(Auth::user()->activities()->paginate(10)->appends(request()->query())), 200);
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
        $validActivity = $request->validate([
            "name" => "required",
            "tag_id" => "required|integer|numeric",
        ]);
        // Should users be able to set activities tags to globally available for other users?
        $validActivity["global"] = false;

        $activity = Activity::create($validActivity);
        Auth::user()->activities()->attach($activity->id);

        return response("Activity Added Successfully", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        return response(new ActivityResource($activity));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        $validActivity = $request->validate([
            "name" => "required",
            "tag_id" => "required|integer|numeric"
        ]);
        // Should users be able to set their activities to globally available for other users? Maybe suggestion section instead?

        $activity->update($validActivity);

        return response("Activity Updated Successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return response("Activity Deleted Successfully", 200);
    }
}
