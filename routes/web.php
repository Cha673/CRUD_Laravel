<?php

use Illuminate\Support\Facades\Route;
use App\Presentation\Http\Controllers\Web\YourController;
use App\Http\Controllers\UserCompositeController;

Route::get('/', function () {
    return view('welcome');
});

// ===================== USERS =====================
Route::get('/users', [YourController::class, 'index'])->name('users.index');
Route::get('/users/create', [YourController::class, 'create'])->name('users.create');
Route::post('/users', [YourController::class, 'add'])->name('users.store');

Route::get('/users/{id}/edit', [YourController::class, 'edit'])->name('users.edit'); 
Route::put('/users/{id}', [YourController::class, 'update'])->name('users.update'); 
Route::delete('/users/{id}', [YourController::class, 'destroy'])->name('users.destroy');

// ===================== ACCOUNTS =====================
Route::get('/accounts/create', [YourController::class, 'createAccount'])->name('accounts.create'); // Formulaire de test
Route::post('/accounts', [YourController::class, 'storeAccount'])->name('accounts.store');        // Créer un compte
Route::delete('/accounts/{id}', [YourController::class, 'destroyAccount'])->name('accounts.destroy'); // Supprimer un compte

// Route pour afficher un utilisateur avec ses comptes (Vue)
Route::get('/users/{id}/details', [UserCompositeController::class, 'showUserWithAccounts'])->name('users.details');
