<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (request $request) {
    return $request->user();
})->middleware('auth:sanctum');

route::post('register',[UserController::class,'registeruser']);
route::post('login',[UserController::class,'login']);