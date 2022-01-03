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

    
    // REFACTOR THIS
    public function createUserTags(Object $user, Object $register) {


        // Create Tags based on Registration Sections
        $faker = \Faker\Factory::create();
        
        // BASE TAGS #########################################################

        $work = Tag::create([
            'name' => 'Work',
            'global' => true,
            'colour' => $faker->hexColor()
        ]);
        $user->tags()->attach($work->id);

        $life = Tag::create([
            'name' => 'Life',
            'global' => true,
            'colour' => $faker->hexColor()
        ]);
        $user->tags()->attach($life->id);

        // WORK ##############################################################

        $education = Tag::create([
            'name' => 'Education',
            'global' => true,
            'parent_id' => $work->id,
            'colour' => $faker->hexColor()
        ]);
        $user->tags()->attach($education->id);
        $career = Tag::create([
            'name' => 'Career',
            'global' => true,
            'parent_id' => $work->id,
            'colour' => $faker->hexColor()
        ]);
        $user->tags()->attach($career->id);
            $portfolio = Tag::create([
                'name' => 'Portfolio',
                'global' => true,
                'parent_id' => $career->id,
                'colour' => $faker->hexColor()
            ]);
            $user->tags()->attach($portfolio->id);
            $skills = Tag::create([
                'name' => 'Skills',
                'global' => true,
                'parent_id' => $career->id,
                'colour' => $faker->hexColor()
            ]);
            $user->tags()->attach($skills->id);

        // LIFE ##############################################################

        $physical = Tag::create([
            'name' => 'Physical',
            'global' => true,
            'parent_id' => $life->id,
            'colour' => $faker->hexColor()
        ]);
        $user->tags()->attach($physical->id);
        $social = Tag::create([
            'name' => 'Social',
            'global' => true,
            'parent_id' => $life->id,
            'colour' => $faker->hexColor()
        ]);
        $user->tags()->attach($social->id);
        $self = Tag::create([
            'name' => 'Self',
            'global' => true,
            'parent_id' => $life->id,
            'colour' => $faker->hexColor()
        ]);
        $user->tags()->attach($self->id);
            $holiday = Tag::create([
                'name' => 'Holiday',
                'global' => true,
                'parent_id' => $self->id,
                'colour' => $faker->hexColor()
            ]);
            $user->tags()->attach($holiday->id);

        // ACTIVITIES

        $activity = Activity::create([
            'name' => 'Go for a run',
            'global' => true,
            'tag_id' => $physical->id
        ]);
        $user->activities()->attach($activity->id);
        $activity = Activity::create([
            'name' => 'Read a book',
            'global' => true,
            'tag_id' => $self->id
        ]);
        $user->activities()->attach($activity->id);
        $activity = Activity::create([
            'name' => 'Meditate',
            'global' => true,
            'tag_id' => $self->id
        ]);
        $user->activities()->attach($activity->id);
        $activity = Activity::create([
            'name' => 'Meet up with friends',
            'global' => true,
            'tag_id' => $social->id
        ]);
        $user->activities()->attach($activity->id);
        $activity = Activity::create([
            'name' => 'Learn a new skill',
            'global' => true,
            'tag_id' => $skills->id
        ]);
        $user->activities()->attach($activity->id);

        // NEW REGISTRATION TAGS ##############################################################
        
        // University and Modules
        $institution = Tag::create([
            'name' => $register->institution,
            'global' => false,
            'parent_id' => $education->id,
            'colour' => $faker->hexColor()
        ]);
        $user->tags()->attach([$institution->id]);
        foreach ($register->modules as $module) {
            $module = Tag::create([
                'name' => $module,
                'global' => false,
                'parent_id' => $institution->id,
                'colour' => $faker->hexColor()
            ]);
            $user->tags()->attach([$module->id]);
        }

        // Company and Projects
        if ($register->employed) {
            $company = Tag::create([
                'name' => $register->company,
                'global' => false,
                'parent_id' => $career->id,
                'colour' => $faker->hexColor()
            ]);
            $user->tags()->attach([$company->id]);
            foreach ($register->projects as $project) {
                $project = Tag::create([
                    'name' => $project,
                    'global' => false,
                    'parent_id' => $company->id,
                    'colour' => $faker->hexColor()
                ]);
                $user->tags()->attach([$module->id]);
            }
        }

        // Physical Clubs
        foreach ($register->physical as $club) {
            $module = Tag::create([
                'name' => $club,
                'global' => false,
                'parent_id' => $physical->id,
                'colour' => $faker->hexColor()
            ]);
            $user->tags()->attach([$module->id]);
        }

        // Social Clubs
        foreach ($register->social as $club) {
            $module = Tag::create([
                'name' => $club,
                'global' => false,
                'parent_id' => $social->id,
                'colour' => $faker->hexColor()
            ]);
            $user->tags()->attach([$module->id]);
        }

        // return true

    }


}
