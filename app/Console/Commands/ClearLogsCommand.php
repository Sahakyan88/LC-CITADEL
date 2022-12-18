<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear laravel.log file, action_logs and error_logs tables from database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::command('logs:clear', function() {

            exec('rm -f ' . storage_path('logs/*.log'));

            exec('rm -f ' . base_path('*.log'));

            $this->comment('Logs have been cleared!');

        })->describe('Clear log files');
    }
}
