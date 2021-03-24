<?php

namespace App\Commands;

use App\Repositories\UserLastMessageRepository;
use App\Telegram\Dto\Keyboard\KeyboardButton;
use App\Telegram\Dto\Keyboard\KeyboardButtonsRow;
use App\Telegram\Dto\Keyboard\ReplyKeyboardMarkup;
use App\Telegram\Request\SendMessageRequest;

class ShowDefaultMenuCommand extends AbstractCommand
{
    public static function getName(): string
    {
        return 'show_default_menu';
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
        $request = new SendMessageRequest($this->getRequestChat(), trans('main.phrases.main_menu'));

        $request->replyMarkup = new ReplyKeyboardMarkup([
            new KeyboardButtonsRow([
                KeyboardButton::makeFromArray(['text' => trans('main.main_menu.add_movie')]),
                KeyboardButton::makeFromArray(['text' => trans('main.main_menu.find_movie')]),
            ]),
            new KeyboardButtonsRow([
                KeyboardButton::makeFromArray(['text' => trans('main.main_menu.get_lists')]),
                KeyboardButton::makeFromArray(['text' => trans('main.main_menu.add_list')]),
            ]),
            new KeyboardButtonsRow([
                KeyboardButton::makeFromArray(['text' => trans('main.main_menu.change_language')]),
            ]),
        ]);

        $request->replyMarkup->oneTimeKeyboard = true;

        return $request;
    }
}
