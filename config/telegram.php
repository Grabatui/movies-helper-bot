<?php

use App\Commands\HelloCommand;
use App\Commands\StartCommand;

return [
    'token' => env('TELEGRAM_TOKEN'),

    'commands' => [
        HelloCommand::class,
        StartCommand::class,
    ],
];
