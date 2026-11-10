<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// Tableau de bord
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// CRUD des équipements
Route::resource('devices', DeviceController::class);
Route::get('devices/{device}/delete', [DeviceController::class, 'confirmDestroy'])
    ->name('devices.confirm-destroy');

// CRUD des salles
Route::resource('rooms', RoomController::class)->parameters(['rooms' => 'room']);
Route::get('rooms/{room}/delete', [RoomController::class, 'confirmDestroy'])
    ->name('rooms.confirm-destroy');

// CRUD des catégories
Route::resource('categories', CategoryController::class)->parameters(['categories' => 'category']);
Route::get('categories/{category}/delete', [CategoryController::class, 'confirmDestroy'])
    ->name('categories.confirm-destroy');

// Ajout d'une intervention
Route::post('devices/{device}/interventions', [InterventionController::class, 'store'])
    ->name('interventions.store');
