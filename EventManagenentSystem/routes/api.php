<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// General Users
Route::post('register', [UserController::class, 'registerUser']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth:api'])->get('profile', [AuthController::class, 'profile']);
Route::get('dashboard', [UserController::class, 'dashboard'])->middleware('auth:api');
Route::get('events', [EventController::class, 'index']);
Route::get('events/{id}', [EventController::class, 'show']);
Route::post('events/{eventId}/register', [RegistrationController::class, 'store'])->middleware('auth:api');

// Admin
Route::middleware(['auth.jwt', 'isAdmin'])->group(function () {
    Route::get('admin/users', [AdminController::class, 'listUsers']);
    Route::put('admin/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('admin/users/{id}', [AdminController::class, 'deleteUser']);
    Route::resource('admin/categories', CategoryController::class);
    Route::get('admin/categories', [CategoryController::class, 'index']);
    Route::get('admin/settings', [SystemSettingsController::class, 'index']);
    Route::post('admin/settings', [SystemSettingsController::class, 'update']);
});

// Public Events (EventController)
Route::resource('events', EventController::class)->only(['index', 'show']);

// Organizers
Route::middleware(['auth.jwt', 'isOrganizer'])->group(function () {
    Route::get('organizer/dashboard', [OrganizerController::class, 'index']);
    Route::get('organizer/events', [OrganizerController::class, 'index'])->name('organizer.events.index');
    Route::post('organizer/events', [OrganizerController::class, 'store'])->name('organizer.events.store');
    Route::get('organizer/events/{id}', [OrganizerController::class, 'show'])->name('organizer.events.show');
    Route::put('organizer/events/{id}', [OrganizerController::class, 'update'])->name('organizer.events.update');
    Route::delete('organizer/events/{id}', [OrganizerController::class, 'destroy'])->name('organizer.events.destroy');
});
