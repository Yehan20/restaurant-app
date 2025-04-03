<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunQueueOnce extends Command
{
    // Command signature to run this command
    protected $signature = 'queue:run-once';

    // Description of what this command does
    protected $description = 'Run the Laravel queue worker once';

    // Execute the command
    public function handle()
    {
        // Run the queue worker once, process all jobs, then stop
        logger('que start');

        // Running the queue:work command with --once flag to stop after completing jobs
        Artisan::call('queue:work', [
            '--once' => true,  // This ensures that the queue processes jobs once and stops
            '--tries' => 3,    // Maximum tries for each job
        ]);

        logger('Que End');

    }
}
