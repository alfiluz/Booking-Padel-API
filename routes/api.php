<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::post('register', [authController::class, 'register']);
Route::post('login', [authController::class, 'login']);
Route::resource('field', FieldController::class);

Route::middleware('auth:api')->group(function () {
    Route::post('order', [OrderController::class, 'store']);
});
