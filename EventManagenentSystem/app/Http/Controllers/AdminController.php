<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function listUsers()
    {
        $users = User::all(); // Adjust the number as needed
        return response()->json($users);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:' . implode(',', [User::ROLE_ADMIN, User::ROLE_ORGANIZER, User::ROLE_PARTICIPANT]),
        ]);

        try {
            $user->update($request->all());
            return response()->json(['message' => 'User updated successfully.', 'user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update user.', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete user.', 'error' => $e->getMessage()], 500);
        }
    }
}
