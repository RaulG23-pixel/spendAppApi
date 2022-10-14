<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8'
        ]);

        $user = User::create([
            "username" => $validateData["username"],
            "email" => $validateData["email"],
            "password" => Hash::make($validateData["password"])
        ]);

        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "message" => "User registered successfully",
            "code" => 201
        ], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials', 'code' => 401], 200);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "message" => "User authentication successful",
            "code" => 200
        ]);
    }
    
    public function update(Request $request){

        $user = User::where('email', $request['email'])->firstOrFail();
        $user->username = $request->input("username");
        $user->email = $request->input("email");
        $user->bio = $request->input("bio");
        $user->update();

        return response(["user" => $user, "response" => "User updated succesfully"],200);
    }

    public function getUser(Request $request)
    {
        return response($request->user(), 200);
    }
    public function logout(Request $request)
    {
        auth()->user()->tokens->delete();
        return response()->json(["message" => "User has been logged out successfully"], 200);
    }
}
