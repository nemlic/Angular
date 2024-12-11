<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CharityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SpamReportController;
use App\Http\Controllers\CommentController;

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
Route::get('charities/search', [CharityController::class, 'search']);

// Donation routes
Route::post('donations', [DonationController::class, 'store'])->middleware('auth:api');
Route::get('donations', [DonationController::class, 'index'])->middleware('auth:api');
Route::get('donations/{id}', [DonationController::class, 'show'])->middleware('auth:api');

// Reporting routes
Route::middleware(['auth:api'])->group(function () {
    Route::get('reports', [ReportController::class, 'index']);
    Route::get('charity-donations/{charityId}', [ReportController::class, 'charityDonations']);
    Route::get('reports', [ReportController::class, 'index'])->middleware('user_type:admin');
    Route::get('charity-reports', [ReportController::class, 'charityReport'])->middleware('user_type:charity');
    Route::get('donor-reports', [ReportController::class, 'donorReport'])->middleware('user_type:donor');
});

// Profile management
Route::middleware('auth:api')->group(function () {
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
});

// Posts routes
Route::middleware(['auth:api', 'user_type:charity'])->group(function () {
    Route::get('posts', [PostController::class, 'index']);
    Route::post('posts', [PostController::class, 'store']);
    Route::get('posts/{id}', [PostController::class, 'show']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);
});

// Like routes
Route::middleware('auth:api')->group(function () {
    Route::post('posts/{postId}/like', [LikeController::class, 'store']);
    Route::delete('posts/{postId}/like', [LikeController::class, 'destroy']);
});

// Spam report routes
Route::middleware('auth:api')->group(function () {
    Route::post('posts/{postId}/spam', [SpamReportController::class, 'store']);
});

// Comment routes
Route::middleware('auth:api')->group(function () {
    Route::get('posts/{postId}/comments', [CommentController::class, 'index']);
    Route::post('posts/{postId}/comments', [CommentController::class, 'store']);
    Route::delete('posts/{postId}/comments/{commentId}', [CommentController::class, 'destroy']);
});

// Test authentication route
Route::middleware('auth:api')->get('/test-auth', function (Request $request) {
    return response()->json(['message' => 'Authenticated successfully!', 'user' => $request->user()]);
});

