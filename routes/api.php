<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    // Route::post('logout', 'logout');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('products', 'index')->middleware('auth:sanctum');
    // Search
    Route::get('products/search', 'search')->middleware('auth:sanctum');
    Route::get('products/{id}', 'show')->middleware('auth:sanctum');
    Route::post('products', 'store')->middleware('auth:sanctum');
    Route::put('products/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('products/{id}', 'destroy')->middleware('auth:sanctum');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('categories', 'index')->middleware('auth:sanctum');
    Route::get('categories/{id}', 'show')->middleware('auth:sanctum');
    Route::post('categories', 'store')->middleware('auth:sanctum');
    Route::put('categories/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('categories/{id}', 'destroy')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
