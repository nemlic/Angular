<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Charity;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'user_type' => 'required|in:donor,charity',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type' => $request->user_type,
        ]);

        // Create a charity profile if user_type is charity
        if ($request->user_type === 'charity') {
            Charity::create([
                'name' => $request->name,
                'description' => 'Please update your charity description.',
                'photo_url' => null
            ]);
        }

        // Generate a JWT token for the user
        $token = JWTAuth::fromUser($user);

        // Return the user and token in the response
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
