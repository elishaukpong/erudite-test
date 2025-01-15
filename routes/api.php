<?php

declare(strict_types=1);

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\V1\EventController;
use App\Http\Controllers\API\V1\EventParticipantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->post('logout', [AuthController::class,'logout']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')
    ->prefix('v1')
    ->group(function(){
        Route::apiResource('events', EventController::class);
        Route::apiResource('events/{event}/participants', EventParticipantController::class)
            ->only(['index','store','destroy']);
    });