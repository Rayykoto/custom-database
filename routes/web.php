<?php

use App\Http\Controllers\{ColumnController, HomeController, DashboardController};
use App\Http\Controllers\Master\FormController;
use App\Http\Controllers\Master\TableController;
use App\Http\Controllers\Master\TableGroupController;
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

    Route::prefix('master/table-group')->group(function() {

        Route::post('add', [TableGroupController::class, 'add'])->name('master.table-group.add');

        Route::post('manage', [TableGroupController::class, 'manage'])->name('master.table-group.manage');

        Route::post('hide_show', [TableGroupController::class, 'hide_show'])->name('master.table-group.hide_show');

    });

    Route::prefix('master/forms')->group( function() {

        Route::get('index', [FormController::class, 'index'])->name('master.forms.index');

        Route::post('create', [FormController::class, 'store']);

        Route::post('add_record', [FormController::class, 'add_record'])->name('master.forms.add_record');

        Route::post('update', [FormController::class, 'update'])->name('master.forms.update');

        Route::post('manage', [FormController::class, 'manage'])->name('master.forms.manage');

        Route::post('delete', [FormController::class, 'delete'])->name('master.forms.delete');

        Route::get('create', [FormController::class, 'create'])->name('master.forms.create');

        Route::get('{form:slug}/edit', [FormController::class, 'edit'])->name('master.forms.edit');

        Route::get('{form:slug}/show', [FormController::class, 'show']);

        Route::get('{form:slug}/get_tables', [FormController::class, 'get_tables']);

        Route::post('{form:slug}/addcolumn', [FormController::class, 'addcolumn']);

        Route::post('{form:slug}/update', [FormController::class, 'update']);

    });

});