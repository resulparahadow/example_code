<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class AppRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'db refreshing';

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
     * @return int
     */
    public function handle()
    {
        $this->call('cache:clear');
        $this->call('config:cache');

        $this->info("refreshing db");

        $this->call('migrate:refresh');
        $this->call('db:seed');

        $this->info("running test");

        // run auth test
        // $test = new Process([
        //     './vendor/bin/phpunit',
        //     'tests/Feature/Api/Auth/AuthTest.php'
        // ]);

        // $test->run();
        // $this->info($test->getOutput());
    }
}
