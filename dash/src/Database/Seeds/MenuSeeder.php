<?php

namespace Bryanjack\Dash\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();
        DB::table('menus')->insert([
            ['name' => 'User Management', 'parent' => 0, 'link' => 'dash.user.index', 'icon' => 'fa fa-users'],
            ['name' => 'Users', 'parent' => 1, 'link' => 'dash.user.index', 'icon' => ''],
            ['name' => 'Roles', 'parent' => 1, 'link' => 'dash.role.index', 'icon' => ''],
            ['name' => 'Permission', 'parent' => 1, 'link' => 'dash.permission.index', 'icon' => ''],
        ]);
    }
}
