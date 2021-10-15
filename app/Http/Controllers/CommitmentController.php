<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Commitment;
use Illuminate\Http\Request;

class CommitmentController extends Controller
{
    
    // GET	/photos	index
    // GET	/photos/create	create
    // POST	/photos	store
    // GET	/photos/{photo}	show
    // GET	/photos/{photo}/edit edit
    // PUT/PATCH	/photos/{photo}	update
    // DELETE	/photos/{photo}	destroy

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $commitment = (object) $request->all();

        // Create User & Role
        $user = Commitment::create($validCommitment);
        return response('Commitment Added Successfully', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commitment  $commitment
     * @return \Illuminate\Http\Response
     */
    public function show(Commitment $commitment)
    {
        //
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
        //
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
