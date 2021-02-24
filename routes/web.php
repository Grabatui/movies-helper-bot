<?php

/** @var BotMan $botman */

use App\Http\Controllers\StartController;
use BotMan\BotMan\BotMan;
use Illuminate\Support\Facades\Route;

$botman = app('botman');

$botman->hears('start', StartController::class . '@start');

Route::any('/botman', function () use ($botman) {
    $botman->listen();
});
