<?php

namespace App\Telegram\Dto\Event;

use App\Telegram\Dto\DtoInterface;

/**
 * @description This object represents a service message about a change in auto-delete timer settings
 *
 * @see https://core.telegram.org/bots/api#messageautodeletetimerchanged
 */
class MessageAutoDeleteTimerChanged implements DtoInterface
{
    /**
     * @description New auto-delete time for messages in the chat
     */
    public int $messageAutoDeleteTime;

    public function __construct(int $messageAutoDeleteTime)
    {
        $this->messageAutoDeleteTime = $messageAutoDeleteTime;
    }

    public static function makeFromArray(array $data): self
    {
        return new static($data['message_auto_delete_time']);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'message_auto_delete_time' => $this->messageAutoDeleteTime,
        ];
    }
}
