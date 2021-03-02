<?php

namespace App\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class RegisterCommand extends Command
{
    protected $name = 'start';

    /**
     * @inheritDoc
     */
    public function handle(): void
    {
        $keyboard = new Keyboard();
        $keyboard->add(
            Keyboard::button('Button 1')
        );
        $keyboard->add(
            Keyboard::button('Button 2')
        );
        $keyboard->setResizeKeyboard(true);

        $this->getTelegram()->sendMessage([
            'text' => 'Hello!',
            'reply_markup' => $keyboard,
        ]);
    }
}
