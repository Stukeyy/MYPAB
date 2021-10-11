<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Tag;
use App\Http\Resources\TagResource;

class TagController extends Controller
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
        $globalTags = Tag::where('global', true)->get();
        $userTags = Auth::user()->tags;
        $mergedTags = $globalTags->merge($userTags);

        return response(TagResource::collection($mergedTags), 200);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
