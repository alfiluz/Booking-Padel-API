<?php

use App\Http\Controllers\authController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::post('register', [authController::class, 'register']);
Route::post('login', [authController::class, 'login']);