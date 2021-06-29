<?php

namespace Bryanjack\Ums\App\Commands;

use Bryanjack\Dash\Database\Seeds\MenuSeeder;
use Illuminate\Console\Command;

class UmsPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ums:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push Public Packages';

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
        $this->info('--Publishing Ums View...');
        $this->call('vendor:publish', [
            '--provider' => "Bryanjack\Ums\UmsServiceProvider",
            '--force' => 'yes'
        ]);
    }
}
