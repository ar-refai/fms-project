<?php

use App\Http\Controllers\BanksController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\TreasuryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuotationController;
use Illuminate\Support\Facades\Route;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// // Main Dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');



// CRUD Routes for Clients
Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/{id}', [ClientController::class, 'show'])->name('clients.show');
        Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/{id}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    });

    // CRUD Routes for Expenses
    Route::prefix('expenses')->group(function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::get('/create', [ExpenseController::class, 'create'])->name('expenses.create');
        Route::post('/', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::get('/{id}', [ExpenseController::class, 'show'])->name('expenses.show');
        Route::get('/{id}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
        Route::put('/{id}', [ExpenseController::class, 'update'])->name('expenses.update');
        Route::delete('/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    });

    // CRUD Routes for Incomes
    Route::prefix('incomes')->group(function () {
        Route::get('/', [IncomeController::class, 'index'])->name('incomes.index');
        Route::get('/create', [IncomeController::class, 'create'])->name('incomes.create');
        Route::post('/', [IncomeController::class, 'store'])->name('incomes.store');
        Route::get('/{id}', [IncomeController::class, 'show'])->name('incomes.show');
        Route::get('/{id}/edit', [IncomeController::class, 'edit'])->name('incomes.edit');
        Route::put('/{id}', [IncomeController::class, 'update'])->name('incomes.update');
        Route::delete('/{id}', [IncomeController::class, 'destroy'])->name('incomes.destroy');
    });

    // CRUD Routes for Treasury Entries
    Route::prefix('treasury')->group(function () {
        Route::get('/', [TreasuryController::class, 'index'])->name('treasury.index');
        Route::get('/create', [TreasuryController::class, 'create'])->name('treasury.create');
        Route::post('/', [TreasuryController::class, 'store'])->name('treasury.store');
        Route::get('/{id}', [TreasuryController::class, 'show'])->name('treasury.show');
        Route::get('/{id}/edit', [TreasuryController::class, 'edit'])->name('treasury.edit');
        Route::put('/{id}', [TreasuryController::class, 'update'])->name('treasury.update');
        Route::delete('/{id}', [TreasuryController::class, 'destroy'])->name('treasury.destroy');
        // Route to start the treasury :
        Route::post('/start', [TreasuryController::class, 'startTreasury'])->name('treasury.start');

    });
        // CRUD Routes for Treasury Entries
        Route::prefix('banks')->group(function () {
            Route::get('/', [BanksController::class, 'index'])->name('banks.index');
            Route::get('/create', [BanksController::class, 'create'])->name('banks.create');
            Route::post('/', [BanksController::class, 'store'])->name('banks.store');
            Route::get('/{id}', [BanksController::class, 'show'])->name('banks.show');
            Route::get('/{id}/edit', [BanksController::class, 'edit'])->name('banks.edit');
            Route::put('/{id}', [BanksController::class, 'update'])->name('banks.update');
            Route::delete('/{id}', [BanksController::class, 'destroy'])->name('banks.destroy');
            // Route to start the banks :
            Route::post('/start', [BanksController::class, 'startBank'])->name('banks.start');

        });

    // CRUD Routes for Projects Entries
    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/{id}', [ProjectController::class, 'show'])->name('projects.show');
        Route::get('/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/{id}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    });
    Route::prefix('quotations')->group(function () {
            Route::post('/', [QuotationController::class, 'store'])->name('quotations.store');
    });
});

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes
require __DIR__ . '/auth.php';
