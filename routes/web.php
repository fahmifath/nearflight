<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'landing'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
