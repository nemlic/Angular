<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Display a listing of all events
    public function index()
    {
        $events = Event::paginate(10); // Adjust the number as needed
        return response()->json($events);
    }

    // Display the specified event
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }
}
