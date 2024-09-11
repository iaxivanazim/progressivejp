<?php
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameTableController;
use App\Http\Controllers\JackpotController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\HouseCommissionController;
use App\Http\Controllers\HandController;
use App\Http\Controllers\JackpotWinnerController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('permission:profile_edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('permission:profile_edit');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('permission:profile_delete');


    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:role_view');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:role_create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:role_create');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:role_edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:role_edit');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:role_delete');

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:permission_view');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:permission_create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:permission_create');
    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:permission_edit');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:permission_edit');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:permission_delete');

    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:users_view');
    Route::get('/users/{users}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:users_edit');
    Route::put('/users/{users}', [UserController::class, 'update'])->name('users.update')->middleware('permission:users_edit');
    Route::delete('/users/{users}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:users_delete');

    Route::get('/game_tables', [GameTableController::class, 'index'])->name('game_tables.index')->middleware('permission:game_tables_view');
    Route::get('/game_tables/create', [GameTableController::class, 'create'])->name('game_tables.create')->middleware('permission:game_tables_create');
    Route::post('/game_tables', [GameTableController::class, 'store'])->name('game_tables.store')->middleware('permission:game_tables_create');
    Route::get('/game_tables/{game_tables}/edit', [GameTableController::class, 'edit'])->name('game_tables.edit')->middleware('permission:game_tables_edit');
    Route::put('/game_tables/{game_tables}', [GameTableController::class, 'update'])->name('game_tables.update')->middleware('permission:game_tables_edit');
    Route::delete('/game_tables/{game_tables}', [GameTableController::class, 'destroy'])->name('game_tables.destroy')->middleware('permission:game_tables_delete');

    Route::get('/jackpots', [JackpotController::class, 'index'])->name('jackpots.index')->middleware('permission:jackpots_view');
    Route::get('/jackpots/create', [JackpotController::class, 'create'])->name('jackpots.create')->middleware('permission:jackpots_create');
    Route::post('/jackpots', [JackpotController::class, 'store'])->name('jackpots.store')->middleware('permission:jackpots_create');
    Route::get('/jackpots/{jackpots}/edit', [JackpotController::class, 'edit'])->name('jackpots.edit')->middleware('permission:jackpots_edit');
    Route::put('/jackpots/{jackpots}', [JackpotController::class, 'update'])->name('jackpots.update')->middleware('permission:jackpots_edit');
    Route::delete('/jackpots/{jackpots}', [JackpotController::class, 'destroy'])->name('jackpots.destroy')->middleware('permission:jackpots_delete');

    Route::get('/house_commissions', [HouseCommissionController::class, 'index'])->name('house_commissions.index')->middleware('permission:house_commissions_view');

    Route::get('/hands', [HandController::class, 'index'])->name('hands.index')->middleware('permission:hands_view');
    Route::get('/hands/create', [HandController::class, 'create'])->name('hands.create')->middleware('permission:hands_create');
    Route::post('/hands', [HandController::class, 'store'])->name('hands.store')->middleware('permission:hands_create');
    Route::get('/hands/{hands}/edit', [HandController::class, 'edit'])->name('hands.edit')->middleware('permission:hands_edit');
    Route::put('/hands/{hands}', [HandController::class, 'update'])->name('hands.update')->middleware('permission:hands_edit');
    Route::delete('/hands/{hands}', [HandController::class, 'destroy'])->name('hands.destroy')->middleware('permission:hands_delete');

    Route::get('/jackpot_winners', [JackpotWinnerController::class, 'index'])->name('jackpot_winners.index')->middleware('permission:jackpot_winners_view');
    Route::get('/jackpot_winners/create', [JackpotWinnerController::class, 'create'])->name('jackpot_winners.create');
    Route::post('/jackpot_winners', [JackpotWinnerController::class, 'store'])->name('jackpot_winners.store');
    Route::get('/jackpot_winners/{jackpot_winners}/edit', [JackpotWinnerController::class, 'edit'])->name('jackpot_winners.edit');
    Route::put('/jackpot_winners/{jackpot_winners}', [JackpotWinnerController::class, 'update'])->name('jackpot_winners.update');
    Route::delete('/jackpot_winners/{jackpot_winners}', [JackpotWinnerController::class, 'destroy'])->name('jackpot_winners.destroy')->middleware('permission:jackpot_winners_delete');
    Route::post('/jackpot_winners/settle/{id}', [JackpotWinnerController::class, 'settle'])->name('jackpot_winners.settle');

    Route::get('/bets/all', [BetController::class, 'showAllBets'])->name('bets.showAll')->middleware('permission:bets_view');
});

Route::middleware('guest')->group(function () {
Route::get('/bets', [BetController::class, 'index'])->name('bets.index');
    Route::post('/bets', [BetController::class, 'store'])->name('bets.store');
    Route::post('/hands/trigger', [HandController::class, 'triggerHandJackpot'])->name('hands.trigger');
});

// Route::middleware(['auth'])->group(function () {
//     // Route::resource('/roles', RoleController::class);
//     Route::resource('/permissions', PermissionController::class);
//     //  Route::resource('users', UserController::class); // For user management
// });

require __DIR__ . '/auth.php';
