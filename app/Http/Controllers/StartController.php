<?php

namespace App\Http\Controllers;

use App\Conversations\RegisterConversation;
use BotMan\BotMan\BotMan;

class StartController extends Controller
{
    public function start(BotMan $bot)
    {
        $bot->startConversation(
            new RegisterConversation()
        );
    }
}
