<?php

use Illuminate\Support\Facades\Route; 
// route guest onlys 
Route::group(['middleware' => ['auth']], function () {
    Route::resource('paramter', Bryanjack\Aplikasi\Controllers\LoginController::class);
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('modul', [Bryanjack\Aplikasi\Controllers\ModulappController::class, 'api'])->name('modul');
    });
});
