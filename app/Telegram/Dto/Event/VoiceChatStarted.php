<?php

namespace App\Telegram\Dto\Event;

use App\Telegram\Dto\DtoInterface;

/**
 * @description This object represents a service message about a voice chat started in the chat. Currently holds no
 * information
 *
 * @see https://core.telegram.org/bots/api#voicechatstarted
 */
class VoiceChatStarted implements DtoInterface
{
    public static function makeFromArray(array $data): self
    {
        return new static();
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [];
    }
}
