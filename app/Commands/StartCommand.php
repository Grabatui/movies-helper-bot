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
            $this->sendAnswerMessage(trans('main.phrases.do_not_understand'));

            return;
        }

        $internalUser = UserRepository::getInstance()->getByExternalId(
            $externalUser->id
        );

        if ($internalUser) {
            // So, we already registered him. Show default keyboard
            $this->handleCommand(
                ShowDefaultMenuCommand::class,
            );
        } else {
            $this->handleCommand(
                ShowLanguageSelectCommand::class
            );
        }
    }
}
