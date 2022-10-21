<?php

use App\Http\Controllers\{ColumnController, HomeController, DashboardController};
use App\Http\Controllers\Master\FormController;
use App\Http\Controllers\Master\TableController;
use Illuminate\Support\Facades\{Route, Auth};

Auth::routes();

Route::get('/', HomeController::class)->name('home');

Route::middleware('auth')->group(function() {
    
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('master/tables')->group(function() {
        
        Route::get('index', [TableController::class, 'index'])->name('master.tables.index');

        Route::post('create', [TableController::class, 'store']);

        Route::get('create', [TableController::class, 'create'])->name('master.tables.create');

    });

    Route::prefix('master/forms')->group( function() {
        
        Route::get('index', [FormController::class, 'index'])->name('master.forms.index'); 

       Route::post('create', [FormController::class, 'store']);

       Route::get('create', [FormController::class, 'create'])->name('master.forms.create');

       Route::get('{form:slug}/edit', [FormController::class, 'edit'])->name('master.forms.edit');

       Route::get('{form:slug}/show', [FormController::class, 'show']);

       Route::post('{form:slug}/addcolumn', [FormController::class, 'addcolumn']);

       Route::post('{form:slug}/update', [FormController::class, 'update']);
    });

});


    