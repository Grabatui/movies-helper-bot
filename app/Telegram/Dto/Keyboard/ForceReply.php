<?php

namespace App\Telegram\Dto\Keyboard;

/**
 * @description Upon receiving a message with this object, Telegram clients will display a reply interface to the user
 * (act as if the user has selected the bot's message and tapped 'Reply'). This can be extremely useful if you want to
 * create user-friendly step-by-step interfaces without having to sacrifice privacy mode
 *
 * @see https://core.telegram.org/bots/api#forcereply
 */
class ForceReply implements KeyboardMarkupInterface
{
    /**
     * @description Shows reply interface to the user, as if they manually selected the bot's message and tapped 'Reply'
     */
    public bool $forceReply;

    /**
     * @description Use this parameter if you want to force reply from specific users only. Targets: 1) users that are
     * @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id),
     * sender of the original message
     */
    public ?bool $selective = null;

    public function __construct(bool $forceReply)
    {
        $this->forceReply = $forceReply;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static($data['force_reply']);

        $entity->selective = $data['selective'] ?? null;

        return $entity;
    }

    public function toArray(): array
    {
        return array_merge(
            [
                'force_reply' => $this->forceReply,
            ],
            clean_nullable_fields([
                'selective' => $this->selective,
            ])
        );
    }
}
