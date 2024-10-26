<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Models\Products;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('add-product',[ProductsController::class,'adding']);
Route::get('allProducts',[ProductsController::class,'getData']);
Route::get('edit-product/{id}',[ProductsController::class,'edit']);
Route::get('delete-product/{id}',[ProductsController::class,'delete']);


