<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Tag;
use App\Http\Resources\TagResource;

class TagController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $globalTags = Tag::where('global', true)->orderBy('id', 'ASC')->get();
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
    public function show(Tag $tag)
    {
        //
    }

    /**
     * This method is called via a separate route which is called when a
     * a tags colour is updated via the colour picker on the Tag Table
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateColour(Request $request, Tag $tag)
    {   
        $newColour = (object) $request->validate([
            "colour" => "required"
        ]);

        $tag->colour = $newColour->colour;
        $tag->save();

        return response("Tag Updated Successfully", 200);
    }

    /**
     * This method is called in apiResource which is called in Tag Update Form
     * Tag is clicked on first and taken to separate form to update all Tag data not only colour
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
