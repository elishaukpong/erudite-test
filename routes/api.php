<?php

declare(strict_types=1);

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->post('logout', [AuthController::class,'logout']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');