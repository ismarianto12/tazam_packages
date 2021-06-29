<?php

// Route::group(['namespace' => 'Bryanjack\Support\Controllers', 'prefix' => '/ums', 'as' => 'ums.', 'middleware' => 'web'], function () {
Route::group(['namespace' => 'Bryanjack\Support\Controllers', 'prefix' => '/ums', 'as' => 'ums.'], function () {
	Route::post('user/get', 'ApiController@user_get')->name('user.get');
	// Route::get('get_user', 'ApiController@check');
	// Route::get('get/{username}', 'ApiController@get');
});
