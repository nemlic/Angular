<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\vehicle;

class VehicleController extends Controller
{
    public function adding(Request $request)
    {
        $items=new Vehicle();
        $items->registration_number=$request->registration_number;
        $items->make=$request->make;
        $items->model=$request->model;
        $items->mfg_year=$request->mfg_year;
        $items->color=$request->color;
        $items->capacity=$request->capacity;
        $items->cc=$request->cc;
        $items->fuel=$request->fuel;
        $items->save();
        return response()->json('Successfully Added');

    }
}
