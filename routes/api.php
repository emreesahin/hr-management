<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('create-superadmin', [AuthController::class, 'createSuperAdmin']);
        Route::patch('promote-to-hr/{userId}', [AuthController::class, 'promoteToHR']);
        Route::get('user-info', [AuthController::class, 'getUserInfo']);
    });
});


Route::get('/test', function(){
    return response()->json(['message' => 'API is working!']);
});
