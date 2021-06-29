<?php

namespace Bryanjack\Ums\App\Commands;

use Bryanjack\Dash\Models\Menu;
use Illuminate\Console\Command;

class UmsInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ums:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all the dependencies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('--Installing Ums Menu..');
        $this->createMenu();
    }

    public function createMenu()
    {
        $menus = collect([
            (object) ['name' => 'UMS', 'parent' => 0, 'link' => '', 'icon' => 'fa fa-users'],
            (object) ['name' => 'Users', 'parent' => 'UMS', 'link' => 'ums.user.index', 'icon' => ''],
            (object) ['name' => 'Roles', 'parent' => 'UMS', 'link' => 'ums.role.index', 'icon' => ''],
            (object) ['name' => 'Permissions', 'parent' => 'UMS', 'link' => 'ums.permission.index', 'icon' => ''],
        ]);

        foreach ($menus as $menu) {
            if ($menu->parent === 0) {
                $parent = Menu::updateOrCreate(['name' => $menu->name], collect($menu)->toArray());
                Menu::where('parent', $parent->id)->delete();
            } else {
                $parent = Menu::where('name', $menu->parent)->first();
                $menu->parent = $parent->id;
                Menu::updateOrCreate(['name' => $menu->name], collect($menu)->toArray());
            }
        }
    }
}
