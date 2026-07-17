<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/devices');

// CRUD complet des équipements 
Route::resource('devices', DeviceController::class);

// Salles 
Route::resource('rooms', RoomController::class)->only(['index', 'create', 'store', 'show']);

// Catégories 
Route::resource('categories', CategoryController::class)->only(['index', 'create', 'store', 'show']);

// Ajout d'une intervention 
Route::post('devices/{device}/interventions', [InterventionController::class, 'store'])->name('interventions.store');