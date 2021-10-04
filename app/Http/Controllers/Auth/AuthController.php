<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function user(Request $request)
    {
        return response([
            'user' => $request->user()
        ]);
    }

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

        return response($request->all());

        // $register = (object) $request->validate([
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8'
        // ]);

        // $user = User::create([
        //     'name' => $register['name'],
        //     'email' => $register['email'],
        //     'password' => Hash::make($register['password'])
        // ]);

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
