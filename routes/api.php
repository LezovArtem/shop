<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function (){
    Route::apiResource('products', \App\Http\Controllers\V1\ProductController::class);
    Route::apiResource('invoices', \App\Http\Controllers\V1\InvoiceController::class);
    Route::apiResource('categories', \App\Http\Controllers\V1\CategoryController::class);
    Route::apiResource('tags', \App\Http\Controllers\V1\TagController::class);
    Route::apiResource('colors', \App\Http\Controllers\V1\ColorController::class);
    Route::apiResource('users', \App\Http\Controllers\V1\UserController::class);
});
