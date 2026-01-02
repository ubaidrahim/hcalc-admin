<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/calculators', App\Http\Controllers\CalculatorsController::class);
});

Route::prefix('frontend')->group(function () {
    Route::get('/category', function () {
        return view('frontend.category');
    })->name('category');

    Route::get('/sub-category', function () {
        return view('frontend.sub-category');
    })->name('sub-category');
    Route::get('/calculator', function () {
        return view('frontend.calculator');
    })->name('calculator');
});


require __DIR__.'/auth.php';
