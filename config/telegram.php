<?php

use App\Commands\Actions\AddMovie\EndAction;
use App\Commands\Actions\AddMovie\PrintMovieNameAction;
use App\Commands\Actions\AddMovie\PrintMovieYearAction;
use App\Commands\Actions\BackAction;
use App\Commands\Actions\ChooseLanguageAction;
use App\Commands\Actions\DoMainMenuAction;
use App\Commands\Actions\FindMovie\FindMovieAction;
use App\Commands\Actions\NextPageAction;
use App\Commands\Actions\PreviousPageAction;
use App\Commands\HelloCommand;
use App\Commands\PrintMoviesListCommand;
use App\Commands\ShowAddMovieCommand;
use App\Commands\ShowDefaultMenuCommand;
use App\Commands\ShowFindMovieCommand;
use App\Commands\ShowLanguageSelectCommand;
use App\Commands\StartCommand;

return [
    'token' => env('TELEGRAM_TOKEN'),

    'commands' => [
        HelloCommand::class,
        StartCommand::class,
        ShowLanguageSelectCommand::class,
        ShowDefaultMenuCommand::class,
        ShowAddMovieCommand::class,
        ShowFindMovieCommand::class,
        PrintMoviesListCommand::class,
    ],

    'actions' => [
        BackAction::class,
        NextPageAction::class,
        PreviousPageAction::class,
        ChooseLanguageAction::class,
        DoMainMenuAction::class,
        PrintMovieNameAction::class,
        PrintMovieYearAction::class,
        EndAction::class,
        FindMovieAction::class,
    ],
];
