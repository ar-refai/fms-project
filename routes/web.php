<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/clients', function () {
    return view('clients');
})->middleware(['auth', 'verified'])->name('clients');

Route::get('/expenses', function () {
    return view('expenses');
})->middleware(['auth', 'verified'])->name('expenses');

Route::get('/revenue', function () {
    return view('revenue');
})->middleware(['auth', 'verified'])->name('revenue');

Route::get('/treasury', function () {
    return view('treasury');
})->middleware(['auth', 'verified'])->name('treasury');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
