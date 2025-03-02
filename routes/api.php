<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('auth/register', Controllers\Auth\RegisterController::class)->withoutMiddleware(['auth:api']); // Register
    Route::post('auth/login', Controllers\Auth\LoginController::class)->withoutMiddleware(['auth:api']); // Login
    Route::get('auth/user', Controllers\Auth\AuthenticatedUserController::class); // Get Auth User Data
    Route::get('auth/refresh', Controllers\Auth\RefreshTokenController::class); // Refresh Token Auth User
    Route::delete('auth/logout', Controllers\Auth\LogoutController::class); // Logout Auth User
    Route::patch('auth/update-account', Controllers\Auth\UpdateAccountController::class); // Update User Account
    Route::patch('auth/update-password', Controllers\Auth\UpdatePasswordController::class); // Update User Password
    Route::post('auth/delete-account', Controllers\Auth\DeleteAccountController::class); // Delete User Account
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('users', [Controllers\UserController::class, 'index']);
    Route::post('users/store', [Controllers\UserController::class, 'store']);
    Route::get('users/{user:id}', [Controllers\UserController::class, 'show']);
    Route::put('users/{user:id}/update', [Controllers\UserController::class, 'update']);
    Route::delete('users/{user:id}/delete', [Controllers\UserController::class, 'delete']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('roles', [Controllers\RoleController::class, 'index']);
    Route::post('roles/store', [Controllers\RoleController::class, 'store']);
    Route::get('roles/{role:id}', [Controllers\RoleController::class, 'show']);
});
