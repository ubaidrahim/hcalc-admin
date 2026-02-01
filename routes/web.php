<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/calculators', App\Http\Controllers\CalculatorsController::class);
    Route::get('/calculator/listAll', [App\Http\Controllers\CalculatorsController::class,'listAll'])->name('calculators.listAll');

    Route::resource('/categories', App\Http\Controllers\CategoryController::class);
    Route::post('/categories/{id}', [App\Http\Controllers\CategoryController::class,'update'])->name('categories.update');
    Route::get('/category/listAll', [App\Http\Controllers\CategoryController::class,'listAll'])->name('categories.listAll');

    Route::resource('/subcategories', App\Http\Controllers\SubcategoryController::class);
    Route::post('/subcategories/{id}', [App\Http\Controllers\SubcategoryController::class,'update'])->name('subcategories.update');
    Route::get('/subcategory/listAll', [App\Http\Controllers\SubcategoryController::class,'listAll'])->name('subcategories.listAll');
    Route::get('/icons/{set}', [App\Http\Controllers\AjaxController::class, 'displayIcons']);

    Route::group(['prefix' => 'content', 'as' => 'content.'],function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
        Route::post('/home', [App\Http\Controllers\HomeController::class, 'store'])->name('home.store');
    });
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
