<?php

Route::group(['prefix' => '/nasabah', 'as' => 'nasabah.', 'middleware' => ['web']], function () {
	Route::get('/install', 'Bryanjack\Nasabah\App\Commands\NasabahInstall@createMenu');
});

Route::group(['namespace' => 'Bryanjack\Nasabah\Controllers', 'prefix' => '/nasabah', 'as' => 'nasabah.', 'middleware' => ['web']], function () {
	Route::get('/', 'NasabahController@index');
});
