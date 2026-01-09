<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/calculators', App\Http\Controllers\CalculatorsController::class);

    Route::resource('/categories', App\Http\Controllers\CategoryController::class);
    Route::get('/category/listAll', [App\Http\Controllers\CategoryController::class,'listAll'])->name('categories.listAll');

    Route::resource('/subcategories', App\Http\Controllers\SubcategoryController::class);
    Route::get('/subcategory/listAll', [App\Http\Controllers\SubcategoryController::class,'listAll'])->name('subcategories.listAll');
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
