<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Empregistration;
use App\Http\Controllers\EmpregistrationController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/employee',EmpregistrationController::class);
