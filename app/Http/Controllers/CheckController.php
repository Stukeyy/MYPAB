<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\Event;
use Illuminate\Http\Request;

class CheckController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Check  $check
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Check $check)
    {   
        $completed = $request->validate([
            "completed" => "required|boolean"
        ]);

        $check->update($completed);
        return response("Check Updated Successfully", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Check  $check
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Check $check)
    {      
        $request = $request->validate([
            "eventID" => "required"
        ]);

        $check->delete();
        return response("Check Deleted Successfully", 200);
    }
}
