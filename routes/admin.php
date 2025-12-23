<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HelperController;
use App\Http\Controllers\Admin\ReceiverController;
use App\Http\Controllers\Admin\CostSourceController;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PrivilegeController;

Route::name('admin.')->group(function () {

    // CATEGORIES
    Route::get('categories', [CategoryController::class, 'index'])
        ->name('categories.index')->middleware('privilege:categories,view');

    Route::get('categories/create', [CategoryController::class, 'create'])
        ->name('categories.create')->middleware('privilege:categories,create');

    Route::post('categories', [CategoryController::class, 'store'])
        ->name('categories.store')->middleware('privilege:categories,create');

    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])
        ->name('categories.edit')->middleware('privilege:categories,edit');

    Route::put('categories/{category}', [CategoryController::class, 'update'])
        ->name('categories.update')->middleware('privilege:categories,edit');

    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy')->middleware('privilege:categories,delete');


    // HELPERS
    Route::get('helpers', [HelperController::class, 'index'])
        ->name('helpers.index')->middleware('privilege:helpers,view');

    Route::get('helpers/create', [HelperController::class, 'create'])
        ->name('helpers.create')->middleware('privilege:helpers,create');

    Route::post('helpers', [HelperController::class, 'store'])
        ->name('helpers.store')->middleware('privilege:helpers,create');

    Route::get('helpers/{helper}/edit', [HelperController::class, 'edit'])
        ->name('helpers.edit')->middleware('privilege:helpers,edit');

    Route::put('helpers/{helper}', [HelperController::class, 'update'])
        ->name('helpers.update')->middleware('privilege:helpers,edit');

    Route::delete('helpers/{helper}', [HelperController::class, 'destroy'])
        ->name('helpers.destroy')->middleware('privilege:helpers,delete');


    // RECEIVERS
    Route::get('receivers', [ReceiverController::class, 'index'])
        ->name('receivers.index')->middleware('privilege:receivers,view');

    Route::get('receivers/create', [ReceiverController::class, 'create'])
        ->name('receivers.create')->middleware('privilege:receivers,create');

    Route::post('receivers', [ReceiverController::class, 'store'])
        ->name('receivers.store')->middleware('privilege:receivers,create');

    Route::get('receivers/{receiver}/edit', [ReceiverController::class, 'edit'])
        ->name('receivers.edit')->middleware('privilege:receivers,edit');

    Route::put('receivers/{receiver}', [ReceiverController::class, 'update'])
        ->name('receivers.update')->middleware('privilege:receivers,edit');

    Route::delete('receivers/{receiver}', [ReceiverController::class, 'destroy'])
        ->name('receivers.destroy')->middleware('privilege:receivers,delete');

    Route::get('receivers/print/{receiver}', [ReceiverController::class, 'print'])
        ->name('receivers.print')->middleware('privilege:receivers,view');

    Route::post('receivers/delete-file', [ReceiverController::class, 'deleteFile'])
        ->name('receivers.deleteFile')->middleware('privilege:receivers,delete');
        
    Route::get('receivers/print/{id}', [ReceiverController::class, 'print'])
        ->name('receivers.print');



    // COST SOURCES
    Route::get('cost_sources', [CostSourceController::class, 'index'])
        ->name('cost_sources.index')
        ->middleware('privilege:cost_sources,view');

    Route::get('cost_sources/create', [CostSourceController::class, 'create'])
        ->name('cost_sources.create')
        ->middleware('privilege:cost_sources,create');

    Route::post('cost_sources', [CostSourceController::class, 'store'])
        ->name('cost_sources.store')
        ->middleware('privilege:cost_sources,create');

    Route::get('cost_sources/{cost_source}/edit', [CostSourceController::class, 'edit'])
        ->name('cost_sources.edit')
        ->middleware('privilege:cost_sources,edit');

    Route::put('cost_sources/{cost_source}', [CostSourceController::class, 'update'])
        ->name('cost_sources.update')
        ->middleware('privilege:cost_sources,edit');

    Route::delete('cost_sources/{cost_source}', [CostSourceController::class, 'destroy'])
        ->name('cost_sources.destroy')
        ->middleware('privilege:cost_sources,delete');




    // COSTS
    Route::get('costs', [CostController::class, 'index'])
        ->name('costs.index')->middleware('privilege:costs,view');

    Route::get('costs/create', [CostController::class, 'create'])
        ->name('costs.create')->middleware('privilege:costs,create');

    Route::post('costs', [CostController::class, 'store'])
        ->name('costs.store')->middleware('privilege:costs,create');

    Route::get('costs/{cost}/edit', [CostController::class, 'edit'])
        ->name('costs.edit')->middleware('privilege:costs,edit');

    Route::put('costs/{cost}', [CostController::class, 'update'])
        ->name('costs.update')->middleware('privilege:costs,edit');

    Route::delete('costs/{cost}', [CostController::class, 'destroy'])
        ->name('costs.destroy')->middleware('privilege:costs,delete');


    // REPORTS
    Route::get('reports/revenue', [ReportController::class, 'revenue'])
        ->name('reports.revenue')->middleware('privilege:reports,view');

    Route::get('reports/cost', [ReportController::class, 'cost'])
        ->name('reports.cost')->middleware('privilege:reports,view');

    Route::get('reports/cashbook', [ReportController::class, 'cashBook'])
        ->name('reports.cash_book')->middleware('privilege:reports,view');


    // ADMINS
    Route::get('admins', [AdminController::class, 'index'])
        ->name('admins.index')->middleware('privilege:admins,view');

    Route::get('admins/create', [AdminController::class, 'create'])
        ->name('admins.create')->middleware('privilege:admins,create');

    Route::post('admins', [AdminController::class, 'store'])
        ->name('admins.store')->middleware('privilege:admins,create');

    Route::get('admins/edit/{id}', [AdminController::class, 'edit'])
        ->name('admins.edit')->middleware('privilege:admins,edit');

    // ADD THIS ROUTE
    Route::put('admins/{id}', [AdminController::class, 'update'])
        ->name('admins.update')->middleware('privilege:admins,edit');

    Route::delete('admins/{id}', [AdminController::class, 'destroy'])
        ->name('admins.destroy')->middleware('privilege:admins,delete');


    Route::delete('admins/{admin}', [AdminController::class, 'destroy'])
        ->name('admins.destroy')->middleware('privilege:admins,delete');


    // PRIVILEGE MANAGEMENT (INDEPENDENT & FULLY LOCKED)
    Route::get('privileges', [PrivilegeController::class, 'index'])
        ->name('privileges.index')->middleware('privilege:privileges,view');

    Route::post('privileges', [PrivilegeController::class, 'store'])
        ->name('privileges.store')->middleware('privilege:privileges,edit');

});
