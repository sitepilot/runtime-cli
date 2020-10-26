<?php

namespace App\Commands;

use Illuminate\Support\Facades\Log;
use LaravelZero\Framework\Commands\Command;

class LogCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'log
                            {message : The log message}
                            {--type=info : The log type}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Log a message';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->option('type');
        $message = $this->argument('message');

        switch ($type) {
            case "error":
                Log::error($message);
                break;
            case "warning":
                Log::warning($message);
                break;
            default:
            case "info":
                Log::info($message);
                break;
        }
    }
}
