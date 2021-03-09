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
        $answerRequest = new SendMessageRequest(
            $this->request->message['chat']['id'],
            'Hello, ' . $this->request->message['from']['first_name']
        );

        $this->facade->sendMessage($answerRequest);
    }
}
