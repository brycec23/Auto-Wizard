<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropdownController;

Route::get('/', [DropdownController::class, 'view'])->name('view');
Route::get('get-models', [DropdownController::class, 'getModels'])->name('getModels');
Route::get('get-generations', [DropdownController::class, 'getGenerations'])->name('getGenerations');
Route::get('get-series', [DropdownController::class, 'getSeries'])->name('getSeries');
Route::get('get-trims', [DropdownController::class, 'getTrims'])->name('getTrims');
//Route::get('get-equipment', [DropdownController::class, 'getEquipment'])->name('getEquipment');
Route::get('get-specs', [DropdownController::class, 'getSpecs'])->name('getSpecs');
