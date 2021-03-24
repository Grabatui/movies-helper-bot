<?php

namespace App\Commands;

use App\Enum\LanguageEnum;
use App\Repositories\UserLastMessageRepository;
use App\Telegram\Dto\Keyboard\InlineKeyboardButton;
use App\Telegram\Dto\Keyboard\InlineKeyboardButtonsRow;
use App\Telegram\Dto\Keyboard\InlineKeyboardMarkup;
use App\Telegram\Request\SendMessageRequest;

class ShowLanguageSelectCommand extends AbstractCommand
{
    public static function getName(): string
    {
        return 'show_language_select';
    }

    public function handle(): void
    {
        $internalUser = $this->getOrCreateUserFromMessage();

        if ( ! $internalUser) {
            return;
        }

        $sendMessageResponse = $this->facade->sendMessage(
            $this->makeLanguagesKeyboardMessage()
        );

        if ($sendMessageResponse->message) {
            UserLastMessageRepository::getInstance()->createOrUpdate(
                $internalUser,
                $sendMessageResponse->message->id,
                static::getName()
            );
        }
    }

    private function makeLanguagesKeyboardMessage(): SendMessageRequest
    {
        $request = new SendMessageRequest($this->getRequestChat(), trans('main.phrases.choose_language'));

        $buttons = [];
        foreach (array_chunk(LanguageEnum::NAMES, 3, true) as $languagesRow) {
            $buttonsRow = new InlineKeyboardButtonsRow();
            foreach ($languagesRow as $language => $name) {
                $button = new InlineKeyboardButton($name);
                $button->callbackData = $language;

                $buttonsRow->add($button);
            }

            $buttons[] = $buttonsRow;
        }

        $request->replyMarkup = new InlineKeyboardMarkup($buttons);

        return $request;
    }
}
