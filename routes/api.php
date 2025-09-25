<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;

// Routes API CRUD
Route::apiResource('items', CrudController::class);