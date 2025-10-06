<?php

use Illuminate\Support\Facades\Route;
use App\Presentation\Http\Controllers\Api\UserApiController;
use App\Presentation\Http\Controllers\AccountController;

// Liste tous les utilisateurs
Route::get('/users', [UserApiController::class, 'index']);

// Créer un utilisateur
Route::post('/users', [UserApiController::class, 'add']);

// Afficher un utilisateur par ID
Route::get('/users/{id}', [UserApiController::class, 'show']);

// Modifier un utilisateur
Route::put('/users/{id}', [UserApiController::class, 'update']);

// Supprimer un utilisateur
Route::delete('/delete/user/{id}', [UserApiController::class, 'destroy']);


Route::get('/accounts', [AccountController::class, 'index']);
Route::post('/accounts', [AccountController::class, 'store']);
Route::delete('/accounts/{id}', [AccountController::class, 'destroy']);


