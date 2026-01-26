<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\BattleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){ return view('login'); });

Route::prefix('players')->group(function () {
    Route::post('/login', [PlayerController::class, 'login'])->name('players.login');
    Route::get('/login', function(){ return view('login'); })->name('players.login');
    Route::get('/', [PlayerController::class, 'index'])->name('players.index');
    Route::get('/create', [PlayerController::class, 'create'])->name('players.create');
    Route::post('/', [PlayerController::class, 'store'])->name('players.store');
    Route::get('/{player}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::put('/{player}', [PlayerController::class, 'update'])->name('players.update');
    Route::delete('/{player}', [PlayerController::class, 'destroy'])->name('players.destroy');
    Route::post('/{player}/add-point', [PlayerController::class, 'addPoint'])->name('players.addPoint');
});


Route::prefix('partidas')->group(function() {
    Route::get('/filter', [BattleController::class, 'filterResultsByMap'])
        ->name('partidas.filterResultsByMap');
});
Route::resource('partidas', BattleController::class);

