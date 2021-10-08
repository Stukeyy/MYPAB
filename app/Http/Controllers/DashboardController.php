<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Tag;
use App\Models\Activity;
use App\Http\Resources\TagResource;

class DashboardController extends Controller
{
    
    public function check() {

        $generation = 0;
        $tag = Tag::find(1);
        $familytree = 'children';

        // builds with relation for tag - children.children.children...
        // gets children of each child decended from tag
        // descendants of each generation from tag
        while ($generation < $tag->descendants) {
            $familytree .= '.children';
            $generation++;
        }

        $tag = Tag::with($familytree)->find(1);
        return response(new TagResource($tag));
    
    }

    public function user(Request $request)
    {
        return response([
            'user' => $request->user()
        ]);
    }

}
