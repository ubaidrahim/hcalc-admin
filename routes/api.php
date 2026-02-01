<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/home-categories',[App\Http\Controllers\Api\HomeController::class,'categories']);
Route::get('/home-meta',[App\Http\Controllers\Api\HomeController::class,'meta']);
Route::get('/home-content',[App\Http\Controllers\Api\HomeController::class,'content']);
Route::prefix('categories')->group(function(){
    Route::get('/',[App\Http\Controllers\Api\CategoriesController::class,'index']);
    Route::get('/fetch/{slug}',[App\Http\Controllers\Api\CategoriesController::class,'show']);
    Route::get('/meta/{slug}',[App\Http\Controllers\Api\CategoriesController::class,'meta']);
});
