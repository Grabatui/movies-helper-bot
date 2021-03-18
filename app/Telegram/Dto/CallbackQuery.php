<?php

namespace App\Telegram\Dto;

use App\Telegram\Dto\Message\Message;

/**
 * @description This object represents an incoming callback query from a callback button in an inline keyboard. If the
 * button that originated the query was attached to a message sent by the bot, the field message will be present. If the
 * button was attached to a message sent via the bot (in inline mode), the field inline_message_id will be present.
 * Exactly one of the fields data or game_short_name will be present
 */
class CallbackQuery implements DtoInterface
{
    /**
     * @description Unique identifier for this query
     */
    public string $id;

    /**
     * @description Sender
     */
    public User $from;

    /**
     * @description Global identifier, uniquely corresponding to the chat to which the message with the callback button
     * was sent. Useful for high scores in games
     */
    public string $chatInstance;

    /**
     * @description Message with the callback button that originated the query. Note that message content and message
     * date will not be available if the message is too old
     */
    public ?Message $message = null;

    /**
     * @description Identifier of the message sent via the bot in inline mode, that originated the query
     */
    public ?string $inlineMessageId = null;

    /**
     * @description Data associated with the callback button. Be aware that a bad client can send arbitrary data in this
     * field
     */
    public ?string $data = null;

    /**
     * @description Short name of a Game to be returned, serves as the unique identifier for the game
     */
    public ?string $gameShortName = null;

    public function __construct(string $id, User $from, string $chatInstance)
    {
        $this->id = $id;
        $this->from = $from;
        $this->chatInstance = $chatInstance;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['id'],
            User::makeFromArray($data['from']),
            $data['chat_instance']
        );

        $entity->message = ! empty($data['message']) ? Message::makeFromArray($data['message']) : null;
        $entity->inlineMessageId = $data['inline_message_id'] ?? null;
        $entity->data = $data['data'] ?? null;
        $entity->gameShortName = $data['game_short_name'] ?? null;

        return $entity;
    }

    public function toArray()
    {
        return array_merge(
            [
                'id' => $this->id,
                'from' => $this->from->toArray(),
                'chat_instance' => $this->chatInstance,
            ],
            clean_nullable_fields([
                'message' => $this->message ? $this->message->toArray() : null,
                'inline_message_id' => $this->inlineMessageId,
                'data' => $this->data,
                'game_short_name' => $this->gameShortName,
            ])
        );
    }
}
