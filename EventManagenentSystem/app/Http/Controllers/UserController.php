<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Event;

class UserController extends Controller
{
    public function registerUser(Request $request)
    {
        try {
            // Validate incoming data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:4|confirmed',
                'role' => 'required|in:' . implode(',', [User::ROLE_ADMIN, User::ROLE_ORGANIZER, User::ROLE_PARTICIPANT]),
            ]);

            // Create a new user with role
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return response()->json([
                'status' => 1,
                'message' => "User Registered Successfully",
                'code' => 200,
            ]);
        } catch (\Exception $e) {
            \Log::error('User registration error: ' . $e->getMessage());
            return response()->json([
                'status' => 0,
                'message' => 'An error occurred while registering the user.',
                'code' => 500,
            ]);
        }
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $dashboardData = [];

        if ($user->role == User::ROLE_ADMIN) {
            // Admin-specific data
            $dashboardData = [
                'message' => 'Admin Dashboard',
                'users_count' => User::count(),
                'events_count' => Event::count(),
            ];
        } elseif ($user->role == User::ROLE_ORGANIZER) {
            // Organizer-specific data
            $dashboardData = [
                'message' => 'Organizer Dashboard',
                'my_events' => Event::where('user_id', $user->id)->get(),
            ];
        } else {
            // Participant-specific data
            $dashboardData = [
                'message' => 'Participant Dashboard',
                'registered_events' => Event::whereHas('participants', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->get(),
            ];
        }

        return response()->json($dashboardData);
    }
}
