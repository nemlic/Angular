<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\attendant;

class AttendantController extends Controller
{
    public function adding(Request $request)
    {
        $request->validate([
            'id_number' => 'required',
            'firstName' => 'required',
            'surname' => 'required',
            'lastName' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'station' => 'required',
            'nextofKin' => 'required',
            'contactofKin' => 'required',
        ]);
    
        $items = new Attendant();
        $items->id_number = $request->id_number;
        $items->firstName = $request->firstName;
        $items->surname = $request->surname;
        $items->lastName = $request->lastName;
        $items->phone = $request->phone;
        $items->email = $request->email;
        $items->station = $request->station;
        $items->nextofKin = $request->nextofKin;
        $items->contactofKin = $request->contactofKin; // Ensure this is correct
        $items->save();
    
        return response()->json('Successfully Added');
    }
}
