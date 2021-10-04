<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function user(Request $request)
  {
    return response([
      'user' => $request->user(),
      'token' => $request->user()->currentAccessToken()
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
    // $user = $request->user();

    // Getting Permissions for User assigned via Role will only return objects which messes up vuex store,
    // this function gets all permissions via roles or direct and stores names only and sends as array
    $permissionNames = [];
    $permissions = $user->getAllPermissions();

    foreach($permissions as $permission) {
      array_push($permissionNames, $permission->name);
    }

    $authDetails = [
      'id' => $user->id,
      'user' => $user,
      'roles' => $user->getRoleNames(),
      'permissions' => $permissionNames
    ];

    return response($authDetails);
  }

  public function register(Request $request)
  {

    $register = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8'
    ]);

    $user = User::create([
      'name' => $register['name'],
      'email' => $register['email'],
      'password' => Hash::make($register['password'])
    ]);

    $token = $user->createToken('token')->plainTextToken;

    return response([
      'user' => $user,
      'token' => $token
    ]);

  }

  public function logout(Request $request)
  {
      Auth::logout();
      return response("GOODBYE");
  }

}
