<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\BattleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PlayerController::class, 'index'])->name('players.index');

Route::prefix('players')->group(function () {
    Route::get('/create', [PlayerController::class, 'create'])->name('players.create');
    Route::post('/', [PlayerController::class, 'store'])->name('players.store');
    Route::get('/{player}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::put('/{player}', [PlayerController::class, 'update'])->name('players.update');
    Route::delete('/{player}', [PlayerController::class, 'destroy'])->name('players.destroy');
    Route::post('/{player}/add-point', [PlayerController::class, 'addPoint'])->name('players.addPoint');
});

Route::resource('partidas', BattleController::class);