<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameTableController;
use App\Http\Controllers\JackpotController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\JackpotWinnerController;
use App\Http\Controllers\HandController;
use App\Http\Controllers\DisplayController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::apiResource('game_tables', GameTableController::class);
// Route::apiResource('jackpots', jackpotController::class);
Route::post('/bets/place', [BetController::class, 'store'])->name('api.bets.store');
Route::put('/jackpot_winners/settle/{id}', [JackpotWinnerController::class, 'settle'])->name('api_jackpot_winners.settle');
Route::get('/jackpot_winners/unsettled', [JackpotWinnerController::class, 'getUnsettledWinners'])->name('jackpot_winners.unsettled');
Route::get('/game_tables', [GameTableController::class, 'getAllGameTables'])->name('game_tables.all');
Route::get('/game_tables/jackpots', [GameTableController::class, 'getAllGameTablesWithJackpots'])->name('game_tables.jackpots');
Route::get('/game_tables/{id}/jackpots', [GameTableController::class, 'getJackpotsByGameTableId'])->name('game_tables.jackpots.byId');
Route::get('/game_tables/hands', [GameTableController::class, 'getAllGameTablesWithHands'])->name('game_tables.hands');
Route::get('/game_tables/hands/{id}', [GameTableController::class, 'getHandsByGameTableId'])->name('game_tables.hands.byId');
Route::get('/hands', [HandController::class, 'getAllHands'])->name('hands.gethands');
Route::post('/hands/trigger', [HandController::class, 'triggerHandWin'])->name('hands.handwins');
Route::get('/displays/{id}', [DisplayController::class, 'show'])->name('displays.show');