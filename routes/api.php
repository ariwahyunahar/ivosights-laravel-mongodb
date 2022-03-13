<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('api')->group(function () {
    Route::resource('todos', App\Http\Controllers\TodolistController::class);
    Route::delete('todos', [App\Http\Controllers\TodolistController::class, 'destroy']);
    
    Route::get('todo/gettodo', [App\Http\Controllers\TodolistController::class, 'gettodo']);
    Route::get('todo/gettodopast', [App\Http\Controllers\TodolistController::class, 'gettodopast']);
    Route::get('todo/gettodofinish', [App\Http\Controllers\TodolistController::class, 'gettodofinish']);
    Route::post('todo/finish', [App\Http\Controllers\TodolistController::class, 'finish']);
});