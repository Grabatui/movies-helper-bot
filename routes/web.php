<?php

/** @var \BotMan\BotMan\BotMan $botman */

use App\Http\Controllers\StartController;

$botman = app('botman');

$botman->hears('start', StartController::class . '@start');

$botman->listen();
