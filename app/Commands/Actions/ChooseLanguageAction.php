<?php

namespace App\Commands\Actions;

use App\Commands\ShowLanguageSelectCommand;
use App\Enum\LanguageEnum;
use App\Repositories\UserLastMessageRepository;

class ChooseLanguageAction extends AbstractAction
{
    public static function getName(): string
    {
        return 'choose_language';
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

        return $lastMessage && $lastMessage->type === ShowLanguageSelectCommand::getName();
    }

    public function handle(): void
    {
        $internalUser = $this->getUserFromCallbackQuery();

        $selectedLanguage = $this->request->callbackQuery->data;

        if ( ! in_array($selectedLanguage, LanguageEnum::ALL)) {
            return;
        }

        $internalUser->language = $selectedLanguage;
        $internalUser->save();

        $this->setLanguage($selectedLanguage);

        $this->sendAnswerMessage(trans('main.phrases.after_register'));

        // TODO: Show default keyboard
    }
}
