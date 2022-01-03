<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Tag;
use App\Models\Activity;
use App\Http\Resources\TagResource;

class DashboardController extends Controller
{
    
    public function check(Tag $tag) {

        return response(new TagResource($tag));
    
    }

    public function user(Request $request)
    {
        return response([
            'user' => $request->user()
        ]);
    }

}
