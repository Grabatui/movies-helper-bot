<?php

namespace App\Telegram\Dto\Event;

use App\Telegram\Dto\DtoInterface;

/**
 * @description This object represents a service message about a voice chat ended in the chat
 *
 * @see https://core.telegram.org/bots/api#voicechatended
 */
class VoiceChatEnded implements DtoInterface
{
    /**
     * @description Voice chat duration; in seconds
     */
    public int $duration;

    public function __construct(int $duration)
    {
        $this->duration = $duration;
    }

    public static function makeFromArray(array $data): self
    {
        return new static($data['duration']);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'duration' => $this->duration,
        ];
    }
}
