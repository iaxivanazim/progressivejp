<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameTableController;
use App\Http\Controllers\JackpotController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\JackpotWinnerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::apiResource('game_tables', GameTableController::class);
Route::apiResource('jackpots', jackpotController::class);
Route::post('/bets/place', [BetController::class, 'store'])->name('api.bets.store');
Route::put('/jackpot_winners/{id}/settle', [JackpotWinnerController::class, 'settle'])->name('jackpot_winners.settle');
Route::get('/jackpot_winners/unsettled', [JackpotWinnerController::class, 'getUnsettledWinners'])->name('jackpot_winners.unsettled');
Route::get('/game_tables', [GameTableController::class, 'getAllGameTables'])->name('game_tables.all');
Route::get('/game_tables/jackpots', [GameTableController::class, 'getAllGameTablesWithJackpots'])->name('game_tables.jackpots');
Route::get('/game_tables/{id}/jackpots', [GameTableController::class, 'getJackpotsByGameTableId'])->name('game_tables.jackpots.byId');