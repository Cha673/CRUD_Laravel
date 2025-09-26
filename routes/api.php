<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YourController;

// Liste tous les utilisateurs
Route::get('/users', [YourController::class, 'index']);

// Créer un utilisateur
Route::post('/users', [YourController::class, 'add']);

// Afficher un utilisateur par ID
Route::get('/users/{id}', [YourController::class, 'show']);

// Modifier un utilisateur
Route::put('/users/{id}', [YourController::class, 'update']);

// Supprimer un utilisateur
Route::delete('/users/{id}', [YourController::class, 'destroy']);
