<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charity;
use App\Models\User;

class CharityController extends Controller
{
    public function index() {
        return Charity::all();
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo_url' => 'nullable|url',
        ]);

        $charity = Charity::create($request->all());

        return response()->json($charity, 201);
    }

    public function show($id) {
        $charity = Charity::findOrFail($id);
        return response()->json($charity);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo_url' => 'nullable|url',
        ]);

        $charity = Charity::findOrFail($id);
        $charity->update($request->all());

        return response()->json($charity);
    }

    public function destroy($id) {
        $charity = Charity::findOrFail($id);
        $charity->delete();

        return response()->json(null, 204);
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'description' => 'required|string',
            'photo_url' => 'nullable|url',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Ensure the user is a charity
        if ($user->user_type !== 'charity') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Find the charity profile associated with the user
        $charity = Charity::where('name', $user->name)->first();

        if ($charity) {
            $charity->update([
                'description' => $request->description,
                'photo_url' => $request->photo_url,
            ]);

            return response()->json($charity);
        } else {
            return response()->json(['error' => 'Charity profile not found'], 404);
        }
    }
}
