<?php

use App\Commands\Actions\AddMovie\EndAction;
use App\Commands\Actions\AddMovie\PrintMovieNameAction;
use App\Commands\Actions\AddMovie\PrintMovieYearAction;
use App\Commands\Actions\BackAction;
use App\Commands\Actions\ChooseLanguageAction;
use App\Commands\Actions\DoMainMenuAction;
use App\Commands\HelloCommand;
use App\Commands\ShowAddMovieSelectCommand;
use App\Commands\ShowDefaultMenuCommand;
use App\Commands\ShowLanguageSelectCommand;
use App\Commands\StartCommand;

return [
    'token' => env('TELEGRAM_TOKEN'),

    'commands' => [
        HelloCommand::class,
        StartCommand::class,
        ShowLanguageSelectCommand::class,
        ShowDefaultMenuCommand::class,
        ShowAddMovieSelectCommand::class,
    ],

    'actions' => [
        BackAction::class,
        ChooseLanguageAction::class,
        DoMainMenuAction::class,
        PrintMovieNameAction::class,
        PrintMovieYearAction::class,
        EndAction::class,
    ],
];
