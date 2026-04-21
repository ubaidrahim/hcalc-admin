<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/calculators', App\Http\Controllers\CalculatorsController::class);
    Route::post('/calculators/{id}', [App\Http\Controllers\CalculatorsController::class,'update'])->name('calculators.update');
    Route::get('/calculator/listAll', [App\Http\Controllers\CalculatorsController::class,'listAll'])->name('calculators.listAll');

    Route::resource('/categories', App\Http\Controllers\CategoryController::class);
    Route::post('/categories/{id}', [App\Http\Controllers\CategoryController::class,'update'])->name('categories.update');
    Route::get('/category/listAll', [App\Http\Controllers\CategoryController::class,'listAll'])->name('categories.listAll');

    Route::resource('/subcategories', App\Http\Controllers\SubcategoryController::class);
    Route::post('/subcategories/{id}', [App\Http\Controllers\SubcategoryController::class,'update'])->name('subcategories.update');
    Route::get('/subcategory/listAll', [App\Http\Controllers\SubcategoryController::class,'listAll'])->name('subcategories.listAll');
    
    Route::get('/subcategories/getByCategory/{categoryId}', [App\Http\Controllers\SubcategoryController::class,'getByCategory'])->name('subcategories.getByCategory');

    Route::resource('/sitescripts', App\Http\Controllers\SiteScriptsController::class);
    Route::post('/sitescripts/{id}', [App\Http\Controllers\SiteScriptsController::class,'update'])->name('sitescripts.update');
    Route::get('/site-script/listAll', [App\Http\Controllers\SiteScriptsController::class,'listAll'])->name('sitescripts.listAll');
    Route::get('/site-script/search/{type}', [App\Http\Controllers\SiteScriptsController::class,'search'])->name('sitescripts.search');

    Route::resource('/team', App\Http\Controllers\TeamController::class);
    Route::post('/team/{id}', [App\Http\Controllers\TeamController::class,'update'])->name('team.update');
    Route::get('/teams/listAll', [App\Http\Controllers\TeamController::class,'listAll'])->name('team.listAll');
    Route::post('/teams/remove-image/{id}', [App\Http\Controllers\TeamController::class,'removeImage'])->name('team.removeImage');

    Route::group(['prefix' => 'content', 'as' => 'content.'],function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
        Route::post('/home', [App\Http\Controllers\HomeController::class, 'store'])->name('home.store');
        
        Route::get('/footer', [App\Http\Controllers\FooterController::class, 'index'])->name('footer.index');
        Route::post('/footer', [App\Http\Controllers\FooterController::class, 'store'])->name('footer.store');
        });
    Route::group(['prefix' => 'visitors', 'as' => 'visitors.'],function () {
        Route::get('/', [App\Http\Controllers\VisitorsController::class, 'index'])->name('index');
        Route::get('/listAll', [App\Http\Controllers\VisitorsController::class, 'listAll'])->name('listAll');
    });
    Route::group(['prefix' => 'settings', 'as' => 'settings.'],function () {
        Route::group(['prefix' => 'website', 'as' => 'website.'],function () {
            Route::get('/', [App\Http\Controllers\WebsiteSettingsController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\WebsiteSettingsController::class, 'store'])->name('store');
            Route::post('update-images', [App\Http\Controllers\WebsiteSettingsController::class,'updateImages'])->name('updateImages');
            Route::post('remove-setting', [App\Http\Controllers\WebsiteSettingsController::class,'removeSetting'])->name('removeSetting');
        });
        Route::group(['prefix' => 'menu', 'as' => 'menu.'],function () {
            Route::get('/{menu?}', [App\Http\Controllers\MenuSettingsController::class, 'index'])->name('index');
            Route::post('/add-item', [App\Http\Controllers\MenuSettingsController::class, 'addItem'])->name('add');
            Route::post('/', [App\Http\Controllers\MenuSettingsController::class, 'store'])->name('store');

        });
    });

    Route::get('status-enable-disable', [App\Http\Controllers\AjaxController::class, 'statusEnableDisable'])->name('statusEnableDisable');
    Route::post('ckeditor/upload', [App\Http\Controllers\AjaxController::class, 'ckeditor_img'])->name('ckeditor.upload');
});


require __DIR__.'/auth.php';
