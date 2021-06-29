<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Bryanjack\Aplikasi\Controllers', 'middleware' => ['web', 'tazamauth']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('modul', 'ModulappController');
    Route::resource('submodul', 'ModulsubController');
    Route::resource('parameter', 'TmparameterController');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('changepass', 'DashboardController@profil')->name('changepass');
        Route::post('actionsave', 'DashboardController@actionsave')->name('actionsave');
    });

    Route::prefix('api')->name('api.')->group(function () {
        Route::get('modul', 'ModulappController@api')->name('modul');
        Route::get('modulsub', 'ModulsubController@api')->name('modulsub');
        Route::post('parameter', 'Tmparameter@api')->name('parameter');
    });
});

Route::group(['namespace' => 'Bryanjack\Aplikasi\Controllers', 'middleware' => ['web']], function () {
    Route::get('/', 'LoginController@index')->name('/');
    Route::post('actionlogin', 'LoginController@AuthProcessed')->name('actionlogin');
    Route::get('logout', 'LoginController@logout')->name('logout');
});
