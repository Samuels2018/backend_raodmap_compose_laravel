<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller {
  public function __construct () {
    $this->middleware('auth:api', ['except' => ['login', 'register']]);
  }

  private function ValidateRegister ($data) {
    return Validator::make($data, [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6|confirmed',
    ]);
  }

  private function validateLogin ($data) {
    return Validator::make($data, [
      'email' => 'required|email',
      'password' => 'required|string',
    ]);
  }

  protected function createNewToken($token){
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
        'user' => auth()->user()
    ]);
  }

  public function register (Request $request) {
    $validator = $this->ValidateRegister($request->all());

    if ($validator->fails()) {
      return response()->json($validator->errors()->toJson(), 400);
    }

    $user = User::create(array_merge(
      $validator->validated(),
      ['password' => bcrypt($request->password)]
    ));

    return response()->json([
      'message' => 'User successfully registered',
      'user' => $user,
    ], 201);
  }

  public function login (Request $request) {
    $validator = $this->validateLogin($request->all());

    if ($validator->fails()) {
      return response()->json($validator->errors()->toJson(), 400);
    }

    if (! $token = auth()->attempt($validator->validated())) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $this->createNewToken($token);
  }

  public function logout () {
    auth()->logout();
    return response()->json(['message' => 'User successfully signed out']);
  }

  public function refresh () {
    return $this->createNewToken(auth()->refresh());
  }

  public function userProfile () {
    return response()->json(auth()->user());
  }


}
