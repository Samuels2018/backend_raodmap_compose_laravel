<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller {
  private function validateUser ($data) {
    return Validator::make($data, [
      'name' => 'required|string|unique:users',
      'password' => 'required|string|min:6',
      'email' => 'required|string|email|max:255|unique:users',
    ]);
  }

  private function validateLogin ($data) {
    return Validator::make($data, [
      'email' => 'required|email',
      'password' => 'required|string',
    ]);
  }


  public function register(Request $request) {
    $validator = $this->validateUser($request->all());

    if ($validator->fails()) {
      return response()->json($validator->errors()->toJson(), 400);
    }

    print_r($request->password);

    $user = User::create([
      'name' => $request->name,
      'password' => Hash::make($request->password),
      'email' => $request->email
    ]);

    return response()->json([
      'user' => $user,
    ], 201);
  }

  public function login(Request $request) {
    $validator = $this->validateLogin($request->all());

    if ($validator->fails()) {
      return response()->json($validator->errors()->toJson(), 400);
    }

    $user = User::where('name', $request->name)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
      throw ValidationException::withMessages([
        'name' => ['The provided credentials are incorrect.'],
      ]);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
      'user' => $user,
      'token' => $token
    ]);
  }

  public function logout(Request $request) {
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logged out successfully']);
  }
}
