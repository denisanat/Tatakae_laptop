<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use Illuminate\View\View;

use App\Http\Controllers\LaptopController;
use App\Http\Controllers\UserController;

// LAPTOP ROUTES
Route::get('/', [LaptopController::class, 'getLaptops'])->name('home');

Route::get('/laptop/{id}', [LaptopController::class, 'show'])->name('laptop');


// USER ROUTES
Route::middleware('auth')->group(function () {
	Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
	Route::inertia('/register', 'Register')->name('register');
	Route::post('/register', [UserController::class, 'register']);

	Route::inertia('/login', 'Login')->name('login');
	Route::post('/login', [UserController::class, 'login']);
});

