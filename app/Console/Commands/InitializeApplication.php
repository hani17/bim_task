<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InitializeApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will run fresh database migrations and test data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $migrateResult = Artisan::call('migrate:fresh');
        $seedResult = Artisan::call('db:seed --class=TestDataSeeder');
        return $migrateResult + $seedResult;
    }
}
