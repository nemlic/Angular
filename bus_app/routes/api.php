<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AttendantController;
use App\Http\Controllers\CustomerController;
use App\Models\attendant;
use App\Models\customer;
use App\Models\vehicle;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('add-vehicle',[VehicleController::class,'adding']);
Route::put('edit-vehicle/{id}',[VehicleController::class,'edit']);
Route::delete('delete-vehicle/{id}',[VehicleController::class,'delete']);



Route::post('add-attendant',[AttendantController::class,'adding']);
Route::put('edit-attendant/{id}',[AttendantController::class,'edit']);
Route::delete('delete-attendant/{id}',[AttendantController::class,'delete']);



Route::post('add-customer',[CustomerController::class,'adding']);
Route::put('edit-customer/{id}',[CustomerController::class,'edit']);
Route::delete('delete-customer/{id}',[CustomerController::class,'delete']);


