<?php

use Illuminate\Support\Facades\Route;
use App\Presentation\Http\Controllers\Api\UserApiController;

// Liste tous les utilisateurs
Route::get('/users', [UserApiController::class, 'index']);

// Créer un utilisateur
Route::post('/users', [UserApiController::class, 'add']);

// Afficher un utilisateur par ID
Route::get('/users/{id}', [UserApiController::class, 'show']);

// Modifier un utilisateur
Route::put('/users/{id}', [UserApiController::class, 'update']);

// Supprimer un utilisateur
Route::delete('/users/{id}', [UserApiController::class, 'destroy']);
