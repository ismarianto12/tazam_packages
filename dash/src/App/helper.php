<?php

use App\Models\User;
use Bryanjack\Dash\Models\Menu;

function pkg_asset($pkg, $path)
{
	return asset('vendor/bryanjack/' . $pkg . '/' . $path);
}

function menu_list()
{
	if (Schema::hasTable('menus')) {
		$menus = Menu::where('parent', '0')->get();
		// $menus = View::share('menus', $menus);
		// dd($wow);
		return $menus;
	} else {
		$message = 'table menus not found';
		$actionPath = explode('/', request()->path())[0];
		if ($actionPath !== 'error') {
			return redirect()->action('\Bryanjack\Dash\Controllers\DashController@error', ['message' => $message])->send();
		}
	}
}

function user_menu()
{
	if (Auth::user()) {
		$user_menu = Auth::user();
	} else {
		// User menu as guest
		$user_menu = User::where('id', '2')->first();
	}
	return $user_menu;
}
