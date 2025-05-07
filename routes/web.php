<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use Illuminate\View\View;

use App\Http\Controllers\LaptopController;

// LAPTOP ROUTES
Route::get('/', [LaptopController::class, 'getLaptops'])->name('home');

Route::get('/laptop/{id}', [LaptopController::class, 'show'])->name('laptop');
