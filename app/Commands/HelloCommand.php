<?php

namespace App\Commands;

use App\Telegram\Request\SendMessageRequest;

class HelloCommand extends AbstractCommand
{
    public function getName(): string
    {
        return 'hello';
    }

    public function handle(): void
    {
        $from = $this->getRequestMessage()->from;

        $answer = $from ? sprintf('Hello, %s!', $from->firstName) : 'Hello!';

        $this->facade->sendMessage(
            new SendMessageRequest($this->getChat(), $answer)
        );
    }
}
