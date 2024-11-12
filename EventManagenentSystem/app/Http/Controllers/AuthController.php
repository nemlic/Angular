<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 0,
                    'code' => 401,
                    'message' => 'Email or Password is incorrect',
                    'data' => null,
                ]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'data' => null,
                'code' => 500,
                'message' => 'Could not create token',
            ]);
        }

        // Get the authenticated user
        $user = auth()->user();

        $data = [
            'token' => $token,
            'user' => [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ];
        
        \Log::info('Login response data: ' . json_encode($data)); // Debug log

        return response()->json([
            'data' => $data,
            'status' => 1,
            'code' => 200,
            'message' => 'Login Successfully',
        ]);
    }

    public function profile()
    {
        $user = auth()->user();

        if ($user) {
            return response()->json([
                'status' => 1,
                'code' => 200,
                'message' => 'User profile retrieved successfully.',
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'code' => 401,
                'message' => 'User not authenticated.',
                'data' => null,
            ]);
        }
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }
}
