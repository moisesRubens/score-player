<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PlayerController::class, 'index'])->name('index');
Route::get('/create', [PlayerController::class, 'create'])->name('create');
Route::post('/', [PlayerController::class, 'store'])->name('store');
Route::get('/{player}/edit', [PlayerController::class, 'edit'])->name('edit');
Route::put('/{player}', [PlayerController::class, 'update'])->name('update');
Route::delete('/{player}', [PlayerController::class, 'destroy'])->name('destroy');
Route::post('/{player}/add-point', [PlayerController::class, 'addPoint'])->name('addPoint');
