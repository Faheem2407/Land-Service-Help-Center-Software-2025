<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HelperController;
use App\Http\Controllers\Admin\ReceiverController;
use App\Http\Controllers\Admin\CostSourceController;
use App\Http\Controllers\Admin\CostController;
use App\Http\Controllers\Admin\ReportController;


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);

    Route::resource('helpers', HelperController::class);

    Route::resource('receivers', ReceiverController::class);

    Route::get('receivers/print/{receiver}', [ReceiverController::class, 'print'])
        ->name('receivers.print');


    Route::post('receivers/delete-file', [ReceiverController::class, 'deleteFile'])
        ->name('receivers.deleteFile');

    Route::get('receivers/get-sub-districts', [ReceiverController::class, 'getSubDistricts'])
         ->name('receivers.getSubDistricts');

    Route::resource('cost_sources', CostSourceController::class);

    Route::get('costs/filter', [CostController::class, 'filter'])->name('costs.filter');
    Route::resource('costs', CostController::class);

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('revenue', [ReportController::class, 'revenue'])->name('revenue');
        Route::get('cost', [ReportController::class, 'cost'])->name('cost');
        Route::get('cashbook', [ReportController::class, 'cashBook'])->name('cash_book');
    });
});
