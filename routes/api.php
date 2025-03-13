<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

// Route::post('/login', [AuthController::class, 'login']);
// Route::middleware('auth-sanctum')->post('/logout', [AuthController::class, 'logout']);


// Route::middleware(['auth-sanctum', 'hr'])->group(function () {
//     Route::apiResource('employees', EmployeeController::class);
// });







Route::prefix('auth')->group(function () {

    // Register route
    Route::post('register', [AuthController::class, 'register']);

    // Login route
    Route::post('login', [AuthController::class, 'login']);

    // Logout route
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

    // Create superadmin (only accessible by superadmin)
    Route::middleware('auth:sanctum')->post('create-superadmin', [AuthController::class, 'createSuperAdmin']);

    // Promote a user to HR (only accessible by superadmin)
    Route::middleware('auth:sanctum')->post('promote-to-hr/{userId}', [AuthController::class, 'promoteToHR']);

});

Route::get('/test', function(){
    return ('API is working!');
});
