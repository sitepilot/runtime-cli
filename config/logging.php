<?php

use App\Logging\RuntimeFormatter;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stdout'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stdout',
            ],
            'formatter' => Monolog\Formatter\LineFormatter::class,
            'formatter_with' => [
                'format' => "[%datetime%] RUNTIME %level_name%: %message%\n",
                'dateFormat' => 'Y-m-d H:i:s',
            ],
        ],

        'stdout' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stdout',
            ],
            'formatter' => Monolog\Formatter\LineFormatter::class,
            'formatter_with' => [
                'format' => "[%datetime%] RUNTIME %level_name%: %message%\n",
                'dateFormat' => 'Y-m-d H:i:s',
            ],
        ],

        'emergency' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stdout',
            ],
            'formatter' => Monolog\Formatter\LineFormatter::class,
            'formatter_with' => [
                'format' => "[%datetime%] RUNTIME %level_name%: %message%\n",
                'dateFormat' => 'Y-m-d H:i:s',
            ],
        ],
    ],

];
