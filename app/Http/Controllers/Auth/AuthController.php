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

        $register = $request->validate([
            "firstname" => "required|string",
            "lastname" => "required|string",
            "age" => "required|integer|numeric",
            "gender" => "required|string",
            "location" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|string|min:6",
            "level" => "required|string",
            "institution" => "required|string",
            "subject" => "required|string",
            "employed" => "required|boolean",
            "company" => "requiredIf:employed,true"
        ]);

        $user = User::create($register);

        return response($user);

        // $token = $user->createToken('token')->plainTextToken;

        // return response([
        //     'user' => $user,
        //     'token' => $token
        // ]);

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response("GOODBYE");
    }

}
