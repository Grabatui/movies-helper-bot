<?php

namespace App\Commands;

class HelloCommand extends AbstractCommand
{
    public static function getName(): string
    {
        return 'hello';
    }

    public function handle(): void
    {
        $from = $this->getRequestMessage()->from;

        $this->sendAnswerMessage(
            $from ? sprintf('Hello, %s!', $from->firstName) : 'Hello!'
        );
    }
}
