<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::apiResource('cards', \App\Http\Controllers\CardController::class);
    Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

#Route::post('/register',     RegisteredUserController::class);

Route::middleware('auth:sanctum')->post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy']);