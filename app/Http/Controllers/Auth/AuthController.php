<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Tag;
use App\Models\Activity;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Log;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        $login = (object) $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            $user = User::where('email', $login->email)->first();
            $token = $user->createToken('token')->plainTextToken;

            return response([
                'user' => $user,
                'token' => $token
            ]);

        }
        else {
            return response(['message' => 'Access Denied'], 401);
        }

    }

    public function authUser(Request $request){

        $user = Auth::user();

        $authDetails = [
            'id' => $user->id,
            'user' => new UserResource($user),
            'name' => $user->fullname,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getPermissionsViaRoles()->pluck('name')
        ];

        return response($authDetails);
    }

    public function checkEmail(Request $request) {
        $validEmail = $request->validate([
            "email" => "required|email|unique:users"
        ]);
        return response("Email Is Unique", 200);
    }

    public function register(Request $request)
    {

        $validRegister = $request->validate([
            "firstname" => "required|string",
            "lastname" => "required|string",
            "age" => "required|integer|numeric",
            "gender" => "required|string",
            "location" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|string|min:6",
            "level" => "required|string",
            "institution" => "required|string",
            "modules" => "nullable",
            "subject" => "required|string",
            "employed" => "required|boolean",
            "company" => "requiredIf:employed,true",
            "projects" => "nullable",
            "physical" => "nullable",
            "social" => "nullable",
        ]);
        $register = (object) $request->all();

        // Create User & Role
        $user = User::create($validRegister)->assignRole('student');

        // Create Tags and Activities for User
        $this->createUserTags($user, $register);

        // Token
        $token = $user->createToken('token')->plainTextToken;

        return response([
            'token' => $token
        ]);

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response("GOODBYE");
    }


    public function createUserTags(Object $user, Object $register) {


        // Create Tags based on Registration Sections
        $faker = \Faker\Factory::create();

        // all BASE tags
        $tags = [
            "Work",
            "Life",
            "Education",
            "Career",
            "Portfolio",
            "Skills",
            "Physical",
            "Social",
            "Self",
            "Holiday"
        ];

        // the children of each tag parent
        $tagFamily = [
            "Work" => [
                "Education",
                "Career"
            ],
            "Career" => [
                "Portfolio",
                "Skills"
            ],
            "Life" => [
                "Physical",
                "Social",
                "Self"
            ],
            "Self" => [
                "Holiday"
            ]
        ];

        // the activities of each tag parent
        $activityFamily = [
            "Physical" => [
                "Go for a run"
            ],
            "Self" => [
                "Read a book",
                "Meditate"
            ],
            "Social" => [
                "Meet up with friends"
            ],
            "Skills" => [
                "Learn a new skill"
            ]
        ];


        // first create all base tags
        foreach($tags as $tag) {
            // colour is fully opaque
            // suggested colour is slightly translucent
            $colour = $faker->hexColor();
            $suggestedColour = $colour . '80';
            $newTag = Tag::create([
                'name' => $tag,
                'global' => true,
                'colour' => $colour,
                'suggested' => $suggestedColour
            ]);
            // also added to user pivot table
            $user->tags()->attach($newTag->id);
        }

        // adds the parent ID to each child tag created
        foreach($tagFamily as $parent => $children) {
            // gets the parent of the tag by the key
            // NOTE need to get latest tag created as same tags created for each user
            // so need ID of most recent one made as this will belong to current user
            $parentTag = Tag::where('name', $parent)->latest('id')->first();
            // adds the parent ID to each child
            foreach($children as $child) {
                $childTag = Tag::where('name', $child)->latest('id')->first();
                $childTag->parent_id = $parentTag->id;
                $childTag->save();
            }
        }

        // creates activities realted to each tag
        foreach ($activityFamily as $parent => $activities) {
            // gets the parent of the tag by the key
            // NOTE need to get latest tag created as same tags created for each user
            // so need ID of most recent one made as this will belong to current user
            $parentTag = Tag::where('name', $parent)->latest('id')->first();
            // creates each activity related to the parent tag and sets it as the parent ID
            foreach($activities as $activity) {
                $activity = Activity::create([
                    'name' => $activity,
                    'global' => true,
                    'tag_id' => $parentTag->id
                ]);
                // adds to user pivot table
                $user->activities()->attach($activity->id);
            }
        }

    }


}
