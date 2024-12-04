<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColleagueController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes for Colleague
Route::middleware(['auth'])->group(function () {
    Route::get('/colleagues', [ColleagueController::class, 'index'])->name('colleagues.index');
    Route::post('/colleagues', [ColleagueController::class, 'store'])->name('colleagues.store');
    Route::get('/colleagues/{colleague}/edit', [ColleagueController::class, 'edit'])->name('colleagues.edit');
    Route::post('/colleagues/{colleague}', [ColleagueController::class, 'update'])->name('colleagues.update');
    Route::delete('/colleagues/{colleague}', [ColleagueController::class, 'destroy'])->name('colleagues.destroy');
});

require __DIR__.'/auth.php';


