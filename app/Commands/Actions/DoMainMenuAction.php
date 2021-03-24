<?php

namespace App\Commands\Actions;

use App\Commands\ShowDefaultMenuCommand;
use App\Commands\ShowLanguageSelectCommand;
use App\Repositories\UserLastMessageRepository;

class DoMainMenuAction extends AbstractAction
{
    public static function getName(): string
    {
        return 'do_main_menu';
    }

    public function isSatisfied(): bool
    {
        $internalUser = $this->getOrCreateUserFromMessage();

        if ( ! $internalUser) {
            return false;
        }

        $lastMessage = UserLastMessageRepository::getInstance()->getByUser(
            $internalUser
        );

        if ( ! $lastMessage || $lastMessage->type !== ShowDefaultMenuCommand::getName()) {
            return false;
        }

        return (
            $this->request->message
            && $this->request->message->text
            && array_key_exists($this->request->message->text, $this->getPossibleAnswers())
        );
    }

    public function handle(): void
    {
        $this->handleCommand(
            $this->getPossibleAnswers()[$this->request->message->text]
        );
    }

    private function getPossibleAnswers(): array
    {
        return [
            trans('main.main_menu.change_language') => ShowLanguageSelectCommand::class,
        ];
    }
}