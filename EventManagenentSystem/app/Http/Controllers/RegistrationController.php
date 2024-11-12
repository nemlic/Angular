<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Mail\RegistrationSuccessful;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    // Store a new registration
    public function store(Request $request, $eventId)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $event = Event::findOrFail($eventId);

        // Check if the user is already registered for the event
        $registration = Registration::where('event_id', $eventId)
                                     ->where('user_id', auth()->id())
                                     ->first();

        if ($registration) {
            return response()->json(['message' => 'You are already registered for this event.'], 409);
        }

        try {
            // Create a new registration
            $registration = new Registration([
                'event_id' => $event->id,
                'user_id' => auth()->id(),
            ]);
            $registration->save();

            Mail::to(auth()->user()->email)->send(new RegistrationSuccessful($event, auth()->user()));

            return response()->json(['message' => 'Registration successful.', 'registration' => $registration]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to register for event.', 'error' => $e->getMessage()], 500);
        }
    }
}
