<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Tag;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // Create Tags based on Registration Sections
        $faker = \Faker\Factory::create();
        $education = Tag::where('name', 'Education')->first();
        $career = Tag::where('name', 'Career')->first();
        $physical = Tag::where('name', 'Physical')->first();
        $social = Tag::where('name', 'Social')->first();
        
        // University and Modules
        $institution = Tag::create([
            'name' => $register->institution,
            'global' => false,
            'parent_id' => $education->id,
            'colour' => $faker->hexColor()
        ]);
        $user->tags()->attach([$institution->id]);
        foreach ($request->modules as $module) {
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
            foreach ($request->projects as $project) {
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
        foreach ($request->physical as $club) {
            $module = Tag::create([
                'name' => $club,
                'global' => false,
                'parent_id' => $physical->id,
                'colour' => $faker->hexColor()
            ]);
            $user->tags()->attach([$module->id]);
        }

        // Social Clubs
        foreach ($request->social as $club) {
            $module = Tag::create([
                'name' => $club,
                'global' => false,
                'parent_id' => $social->id,
                'colour' => $faker->hexColor()
            ]);
            $user->tags()->attach([$module->id]);
        }

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

}
