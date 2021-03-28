<?php

namespace App\Commands;

/**
 * @description Just saying hello
 */
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
