<?php

namespace App\Telegram\Request;

use App\Telegram\Dto\Chat\Chat;
use App\Telegram\Dto\Keyboard\KeyboardMarkupInterface;
use App\Telegram\Dto\Message\MessageEntity;
use App\Telegram\Response\ResponseInterface;
use App\Telegram\Response\SendMessageResponse;

/**
 * @description Use this method to send text messages
 */
class SendMessageRequest extends AbstractPostRequest
{
    /**
     * @description Chat or username of the target channel (in the format @channelusername)
     */
    public Chat $chat;

    /**
     * @description Text of the message to be sent, 1-4096 characters after entities parsing
     */
    public string $text;

    /**
     * @description Mode for parsing entities in the message text
     */
    public ?string $parseMode = null;

    /**
     * @var MessageEntity[]
     *
     * @description List of special entities that appear in message text, which can be specified instead of parse_mode
     */
    public array $entities = [];

    /**
     * @description Disables link previews for links in this message
     */
    public ?bool $disableWebPagePreview = null;

    /**
     * @description Sends the message silently. Users will receive a notification with no sound
     */
    public ?bool $disableNotification = null;

    /**
     * @description If the message is a reply, ID of the original message
     */
    public ?bool $replyToMessageId = null;

    /**
     * @description Pass True, if the message should be sent even if the specified replied-to message is not found
     */
    public ?bool $allowSendingWithoutReplay = null;

    /**
     * @description Additional interface options. A JSON-serialized object for an inline keyboard, custom reply
     * keyboard, instructions to remove reply keyboard or to force a reply from the user
     */
    public ?KeyboardMarkupInterface $replyMarkup = null;

    public function __construct(Chat $chat, string $text)
    {
        $this->chat = $chat;
        $this->text = $text;
    }

    public function getUri(): string
    {
        return '/sendMessage';
    }

    public function toArray(): array
    {
        return array_merge(
            [
                'chat_id' => $this->chat->id,
                'text' => $this->text,
            ],
            clean_nullable_fields([
                'parse_mode' => $this->parseMode,
                'disable_web_page_preview' => $this->disableWebPagePreview,
                'disable_notification' => $this->disableNotification,
                'reply_to_message_id' => $this->replyToMessageId,
                'allow_sending_without_reply' => $this->allowSendingWithoutReplay,
                'reply_markup' => $this->replyMarkup ? $this->replyMarkup->toArray() : null,
                'entities' => $this->entities ? array_of_objects_to_arrays($this->entities) : null,
            ])
        );
    }

    public function makeResponse(array $rawResponse): ResponseInterface
    {
        return new SendMessageResponse($rawResponse);
    }
}
