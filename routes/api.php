<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YourController;

// Routes pour les utilisateurs
Route::get('/users', [YourController::class, 'index']);
Route::post('/users', [YourController::class, 'add']);