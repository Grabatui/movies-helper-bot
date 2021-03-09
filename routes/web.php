<?php

use App\Http\Controllers\TelegramController;

Route::any('/', [TelegramController::class, 'hears'])->middleware('logger');
