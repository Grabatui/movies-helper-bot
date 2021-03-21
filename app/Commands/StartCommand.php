<?php

namespace App\Commands;

use App\Repositories\UserRepository;

class StartCommand extends AbstractCommand
{
    public static function getName(): string
    {
        return 'start';
    }

    public function handle(): void
    {
        $externalUser = $this->getRequestMessage()->from;

        if ( ! $externalUser || $externalUser->isBot) {
            $this->sendAnswerMessage('I can\'t recognize you :(');

            return;
        }

        $internalUser = UserRepository::getInstance()->getByExternalUserId(
            $externalUser->id
        );

        if ($internalUser) {
            // So, we already registered him. Show default keyboard
            // TODO: Show default keyboard
        } else {
            $this->handleCommand(
                ShowLanguageSelectCommand::class
            );
        }
    }
}
