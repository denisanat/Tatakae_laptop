<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use Illuminate\View\View;

use App\Http\Controllers\LaptopController;
use App\Http\Controllers\UserController;

// LAPTOP ROUTES
Route::get('/', [LaptopController::class, 'getLaptops'])->name('home');

Route::get('/laptop/{id}', [LaptopController::class, 'show'])->name('laptop');
Route::post('/laptop/{id}/rate', [LaptopController::class, 'rate'])->name('laptop.rate');
Route::post('/laptop/{id}/comment', [LaptopController::class, 'comment'])->name('laptop.comment');
Route::post('/laptop/{id}/reply', [LaptopController::class, 'reply'])->name('laptop.reply');

Route::get('/laptop/{id}/answers', [LaptopController::class, 'getAnswers']);

// CREATE ROUTES
Route::get('/create', [LaptopController::class, 'goCreate'])->name('gocreate');
Route::post('/create_hardware', [LaptopController::class, 'createHardware']);
Route::post('/create_laptop', [LaptopController::class, 'createLaptop']);


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

