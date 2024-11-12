<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrganizerController extends Controller
{
    public function index()
    {
        \Log::info('OrganizerController@index');

        try {
            $organizer = Auth::user();
            \Log::info('Authenticated User: ', ['user' => $organizer]);

            $events = Event::where('user_id', $organizer->id)->paginate(10);
            \Log::info('Fetched Events: ', ['events' => $events]);

            return response()->json([
                'message' => 'Organizer Dashboard',
                'organizer' => $organizer,
                'events' => $events,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in OrganizerController@index: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $event = new Event($request->all());
            $event->user_id = Auth::id();
            \Log::info('Creating Event: ', ['event' => $event]);

            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $event->image = $imageName;
                \Log::info('Uploaded Image: ', ['image' => $imageName]);
            }

            $event->save();
            \Log::info('Event Created Successfully: ', ['event' => $event]);

            return response()->json(['message' => 'Event created successfully.', 'event' => $event]);
        } catch (\Exception $e) {
            \Log::error('Error in OrganizerController@store: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to create event.', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        \Log::info('OrganizerController@show', ['event_id' => $id]);

        try {
            $event = Event::where('user_id', Auth::id())->findOrFail($id);
            \Log::info('Fetched Event: ', ['event' => $event]);
            return response()->json($event);
        } catch (\Exception $e) {
            \Log::error('Error in OrganizerController@show: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to fetch event.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        \Log::info('OrganizerController@update', ['event_id' => $id]);

        try {
            $event = Event::where('user_id', Auth::id())->findOrFail($id);
            \Log::info('Fetched Event for Update: ', ['event' => $event]);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'date' => 'required|date',
                'location' => 'required|string',
                'category' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $event->update($request->except('image'));
            \Log::info('Updated Event: ', ['event' => $event]);

            if ($request->hasFile('image')) {
                if ($event->image && file_exists(public_path('images/' . $event->image))) {
                    unlink(public_path('images/' . $event->image));
                }
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $event->image = $imageName;
                \Log::info('Updated Event Image: ', ['image' => $imageName]);
            }

            $event->save();
            \Log::info('Event Updated Successfully: ', ['event' => $event]);

            return response()->json(['message' => 'Event updated successfully.', 'event' => $event]);
        } catch (\Exception $e) {
            \Log::error('Error in OrganizerController@update: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to update event.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        \Log::info('OrganizerController@destroy', ['event_id' => $id]);

        try {
            $event = Event::where('user_id', Auth::id())->findOrFail($id);

            if ($event->image && file_exists(public_path('images/' . $event->image))) {
                unlink(public_path('images/' . $event->image));
            }
            
            $event->delete();
            \Log::info('Event Deleted Successfully: ', ['event' => $event]);
            return response()->json(['message' => 'Event deleted successfully.']);
        } catch (\Exception $e) {
            \Log::error('Error in OrganizerController@destroy: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to delete event.', 'error' => $e->getMessage()], 500);
        }
    }
}
