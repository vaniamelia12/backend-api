<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['api.auth'])->group(function () {

    // Auth
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);

    // Admin only
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/users', function () {
            return response()->json([
                'message' => 'Halaman admin',
                'data' => \App\Models\User::all(),
            ]);
        });
    });

    // Admin + Dosen
    Route::middleware(['role:admin,dosen'])->group(function () {
        Route::get('/manage/data', function () {
            return response()->json([
                'message' => 'Halaman admin & dosen',
            ]);
        });
    });

});