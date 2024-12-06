<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CharityController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Charity routes
Route::get('charities', [CharityController::class, 'index']);
Route::post('charities', [CharityController::class, 'store']);
Route::get('charities/{id}', [CharityController::class, 'show']);
Route::put('charities/{id}', [CharityController::class, 'update']);
Route::delete('charities/{id}', [CharityController::class, 'destroy']);
Route::put('charities/update', [CharityController::class, 'updateProfile'])->middleware('auth:api');