<?php

namespace Bryanjack\Dash\App\Commands;

use Bryanjack\Dash\Database\Seeds\MenuSeeder;
use Illuminate\Console\Command;

class DashInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dash:install {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Dash';

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
        // Database migration
        $force = $this->option('force');
        if ($force) {
            $this->info('--Migrating database force');
            $this->call('migrate', [
                '--force' => 'yes'
            ]);
        } else {
            $this->info('--Migrating database');
            $this->call('migrate');
        }

        // Seeder
        $this->info('--Seed database for dash Run..');
        $this->call(MenuSeeder::class);

        // Publish
        $this->info('--Publishing dash configuration...');
        $this->call('vendor:publish', [
            '--provider' => "Bryanjack\Dash\DashServiceProvider",
            '--force' => 'yes'
        ]);
    }
}
