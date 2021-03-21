<?php

use App\Commands\Actions\ChooseLanguageAction;
use App\Commands\HelloCommand;
use App\Commands\ShowLanguageSelectCommand;
use App\Commands\StartCommand;

return [
    'token' => env('TELEGRAM_TOKEN'),

    'commands' => [
        HelloCommand::class,
        StartCommand::class,
        ShowLanguageSelectCommand::class,
    ],

    'actions' => [
        ChooseLanguageAction::class,
    ],
];
