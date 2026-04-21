<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/home-categories',[App\Http\Controllers\Api\HomeController::class,'categories']);
Route::get('/home-meta',[App\Http\Controllers\Api\HomeController::class,'meta']);
Route::get('/home-content',[App\Http\Controllers\Api\HomeController::class,'content']);
Route::get('/footer-categories',[App\Http\Controllers\Api\FooterController::class,'categories']);
Route::get('/footer-content',[App\Http\Controllers\Api\FooterController::class,'content']);
Route::get('/site-scripts',[App\Http\Controllers\Api\SiteScriptsController::class,'index']);
Route::prefix('categories')->group(function(){
    Route::get('/',[App\Http\Controllers\Api\CategoriesController::class,'index']);
    Route::get('/fetch/{slug}',[App\Http\Controllers\Api\CategoriesController::class,'show']);
    Route::get('/meta/{slug}',[App\Http\Controllers\Api\CategoriesController::class,'meta']);
});
Route::prefix('calculator')->group(function(){
    Route::get('/',[App\Http\Controllers\Api\CalculatorsController::class,'index']);
    Route::get('/famous',[App\Http\Controllers\Api\CalculatorsController::class,'famous']);
    Route::get('/recent',[App\Http\Controllers\Api\CalculatorsController::class,'recent']);
    Route::get('/fetch/{slug}',[App\Http\Controllers\Api\CalculatorsController::class,'show']);
    Route::get('/meta/{slug}',[App\Http\Controllers\Api\CalculatorsController::class,'meta']);
    Route::post('/search',[App\Http\Controllers\Api\CalculatorsController::class,'search']);
});
Route::prefix('contact')->group(function(){
    Route::post('send-message',[App\Http\Controllers\Api\ContactMessageController::class,'sendMessage']);
});
Route::prefix('team')->group(function(){
    Route::get('/',[App\Http\Controllers\Api\TeamController::class,'index']);
});
Route::prefix('visitors')->group(function(){
    Route::post('/init',[App\Http\Controllers\Api\VisitorsController::class,'init']);
    Route::post('/track',[App\Http\Controllers\Api\VisitorsController::class,'store']);
});
Route::prefix('menu')->group(function(){
    Route::get('/{menu}',[App\Http\Controllers\Api\MenuController::class,'show']);
});
Route::prefix('setting')->group(function(){
    Route::get('/{key}',[App\Http\Controllers\Api\SettingsController::class,'show']);
});
Route::prefix('calculation')->group(function(){
    Route::post('/record',[App\Http\Controllers\Api\CalculatorsController::class,'recordCalculation']);
    Route::get('/fetch/{uuid}',[App\Http\Controllers\Api\CalculatorsController::class,'fetchCalculation']);
});
Route::prefix('feedback')->group(function(){
    Route::post('/fetch',[App\Http\Controllers\Api\FeedbackController::class,'fetch']);
    Route::post('/store',[App\Http\Controllers\Api\FeedbackController::class,'store']);
});
