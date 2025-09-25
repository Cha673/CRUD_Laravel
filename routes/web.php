<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YourController;

Route::get('/', function () {
    return view('welcome');
});

// Routes pour les utilisateurs
Route::get('/users', [YourController::class, 'index'])->name('users.index');
Route::get('/users/create', [YourController::class, 'create'])->name('users.create');
Route::post('/users', [YourController::class, 'add'])->name('users.store');

Route::get('/users/{id}/edit', [YourController::class, 'edit'])->name('users.edit');    // Formulaire de modification
Route::put('/users/{id}', [YourController::class, 'update'])->name('users.update');      // Met à jour un utilisateur
Route::delete('/users/{id}', [YourController::class, 'destroy'])->name('users.destroy'); // Supprime un utilisateur

