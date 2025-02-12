<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', Controllers\Auth\RegisterController::class);

Route::post('auth/login', Controllers\Auth\LoginController::class);

Route::get('auth/user', Controllers\Auth\AuthenticatedUserController::class)->middleware('auth:api');

Route::get('auth/refresh', Controllers\Auth\RefreshTokenController::class)->middleware('auth:api');

Route::delete('auth/logout', Controllers\Auth\LogoutController::class)->middleware('auth:api');
