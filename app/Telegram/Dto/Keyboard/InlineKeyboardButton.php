<?php

namespace App\Telegram\Dto\Keyboard;

use App\Telegram\Dto\DtoInterface;

/**
 * @description This object represents one button of an inline keyboard. You must use exactly one of the optional fields
 *
 * @see https://core.telegram.org/bots/api#inlinekeyboardbutton
 */
class InlineKeyboardButton implements DtoInterface
{
    /**
     * @description Label text on the button
     */
    public string $text;

    /**
     * @description HTTP or tg:// url to be opened when button is pressed
     */
    public ?string $url = null;

    /**
     * @description An HTTP URL used to automatically authorize the user. Can be used as a replacement for the Telegram
     * Login Widget
     */
    public ?LoginUrl $loginUrl = null;

    /**
     * @description Data to be sent in a callback query to the bot when button is pressed, 1-64 bytes
     */
    public ?string $callbackData = null;

    /**
     * @description If set, pressing the button will prompt the user to select one of their chats, open that chat and
     * insert the bot's username and the specified inline query in the input field. Can be empty, in which case just
     * the bot's username will be inserted
     */
    public ?string $switchInlineQuery = null;

    /**
     * @description  If set, pressing the button will insert the bot's username and the specified inline query in the
     * current chat's input field. Can be empty, in which case only the bot's username will be inserted
     */
    public ?string $switchInlineQueryCurrentChat = null;

    /**
     * @description Description of the game that will be launched when the user presses the button
     */
    public ?CallbackGame $callbackGame = null;

    /**
     * @description Specify True, to send a Pay button
     */
    public ?bool $pay = null;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static($data['text']);

        $entity->url = $data['url'] ?? null;
        $entity->loginUrl = ! empty($data['login_url']) ? LoginUrl::makeFromArray($data['login_url']) : null;
        $entity->callbackData = $data['callback_data'] ?? null;
        $entity->switchInlineQuery = $data['switch_inline_query'] ?? null;
        $entity->switchInlineQueryCurrentChat = $data['switch_inline_query_current_chat'] ?? null;
        $entity->callbackGame = ! empty($data['callback_game'])
            ? CallbackGame::makeFromArray($data['callback_game'])
            : null;
        $entity->pay = $data['pay'] ?? null;

        return $entity;
    }

    public function toArray()
    {
        return array_merge(
            [
                'text' => $this->text,
            ],
            clean_nullable_fields([
                'url' => $this->url,
                'login_url' => $this->loginUrl ? $this->loginUrl->toArray() : null,
                'callback_data' => $this->callbackData,
                'switch_inline_query' => $this->switchInlineQuery,
                'switch_inline_query_current_chat' => $this->switchInlineQueryCurrentChat,
                'callback_game' => $this->callbackGame ? $this->callbackGame->toArray() : null,
                'pay' => $this->pay,
            ])
        );
    }
}
