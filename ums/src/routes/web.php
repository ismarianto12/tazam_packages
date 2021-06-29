<?php

// use Illuminate\Routing\Route;

use Bryanjack\Ums\Models\UmsUser;

Route::group(['namespace' => 'Bryanjack\Ums\Controllers', 'prefix' => '/', 'middleware' => ['web']], function () {
	Route::post('/dash/login', 'LoginController@login');
	Route::post('/dash/logout', 'LoginController@umsLogout')->name('dash.logout');
});

Route::group(['prefix' => '/ums', 'as' => 'ums.', 'middleware' => ['web']], function () {
	Route::get('/install', 'Bryanjack\Ums\App\Commands\UmsInstall@createMenu');
});

Route::group(['namespace' => 'Bryanjack\Ums\Controllers', 'prefix' => '/ums', 'as' => 'ums.', 'middleware' => ['web']], function () {
	Route::get('/role/user_role', 'RoleController@user')->name('role.user');
	Route::get('/role/permissions', 'UserController@get_permissions')->name('role.permissions');

	Route::get('/user/active_inactive', 'UserController@active_inactive_user')->name('user.active_inactive');

	Route::get('/access/create', 'UserController@app_create')->name('access.create');
	Route::get('/access/edit', 'UserController@app_edit')->name('access.edit');

	Route::post('/access/store', 'UserController@access_store')->name('access.store');
	Route::post('/access/update', 'UserController@access_update')->name('access.update');

	Route::get('/access/roles', 'UserController@access_rolesapp')->name('access.roles');
	Route::get('/access/permissions', 'UserController@access_permissionsapp')->name('access.permissions');

	Route::get('/role/app', 'RoleController@app_role')->name('role.app');
	Route::get('/app/create_role', 'RoleController@create_role')->name('app.create_role');
	Route::get('/app/edit_role', 'RoleController@edit_role')->name('app.edit_role');
	Route::post('/app/store_role', 'RoleController@store_role')->name('app.store_role');
	Route::post('/app/update_role', 'RoleController@update_role')->name('app.update_role');
	Route::get('/role/active_inactive', 'RoleController@active_inactive_role')->name('role.active_inactive');

	Route::get('/permission/app', 'PermissionController@app_permission')->name('permission.app');
	Route::get('/app/create_permission', 'PermissionController@create_permission')->name('app.create_permission');
	Route::get('/app/edit_permission', 'PermissionController@edit_permission')->name('app.edit_permission');
	Route::post('/app/store_permission', 'PermissionController@store_permission')->name('app.store_permission');
	Route::post('/app/update_permission', 'PermissionController@update_permission')->name('app.update_permission');
	Route::get('/permission/active_inactive', 'PermissionController@active_inactive_permission')->name('permission.active_inactive');

	Route::get('/app/roles', 'UserController@get_rolesapp')->name('app.roles');
	Route::get('/app/permissions', 'UserController@get_permissionsapp')->name('app.permissions');

	Route::get('/app/additionals', 'UserController@get_additionalsapp')->name('app.additionals');
	Route::get('/app/unit', 'UserController@get_unit')->name('app.unit');
	Route::get('/app/status', 'UserController@get_status')->name('app.status');
	Route::get('/app/list', 'UserController@get_apps')->name('app.list');
	Route::get('/app/active_inactive', 'UserController@active_inactive_user_app')->name('app.active_inactive');
});

Route::group(['namespace' => 'Bryanjack\Ums\Controllers', 'prefix' => '/ums', 'as' => 'ums.', 'middleware' => ['web', 'auth']], function () {
	Route::resource('/user', 'UserController');
	Route::resource('/role', 'RoleController');
	Route::resource('/permission', 'PermissionController');
	Route::get('/test', 'UserController@get_apps');
});