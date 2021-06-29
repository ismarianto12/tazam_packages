<?php

use Illuminate\Support\Facades\Auth;

Route::group(['namespace' => 'Bryanjack\Dash\Controllers', 'prefix' => '/dash', 'as' => 'dash.', 'middleware' => 'web'], function () {
	// This one is default
	// Because cannot enable this function
	// Auth::routes(['verify' => true]);
	// Route::get('login', 'Auth\LoginController@showLoginForm')->name('log');
	// portal\vendor\laravel\framework\src\Illuminate\Support\Facades\Auth.php
	// portal\vendor\laravel\framework\src\Illuminate\Routing\Router.php

	// state the auth routes manually
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('register', 'Auth\RegisterController@register');
});

Route::group(['namespace' => 'Bryanjack\Dash\Controllers', 'middleware' => 'web'], function () {
	Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
	Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
	Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
});

Route::group(['namespace' => 'Bryanjack\Dash\Controllers', 'middleware' => 'web'], function () {
	Route::get('/dash', 'DashController@index')->name('dash.index');
	Route::get('/error/{message}', 'DashController@error')->name('error');
});

// Ums
Route::group(['namespace' => 'Bryanjack\Dash\Controllers', 'prefix' => '/dash', 'as' => 'dash.', 'middleware' => ['web', 'auth']], function () {
	Route::resource('/user', 'UserController');
	Route::resource('/role', 'RoleController');
	Route::resource('/permission', 'PermissionController');
});

Route::group(['namespace' => 'Bryanjack\Dash\Controllers', 'middleware' => 'web'], function () {
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});


if (!Route::has('login')) {
	Route::group(['namespace' => 'Bryanjack\Dash\Controllers', 'middleware' => 'web'], function () {
		// Route::get('/dash/login', 'Auth\LoginController@showLoginForm')->name('dash.login');
		Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
	});
}