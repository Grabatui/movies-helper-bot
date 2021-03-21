<?php

namespace App\Telegram\Dto\Keyboard;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\Field\PollType;

/**
 * @description This object represents type of a poll, which is allowed to be created and sent when the corresponding
 * button is pressed
 *
 * @see https://core.telegram.org/bots/api#keyboardbuttonpolltype
 */
class KeyboardButtonPollType implements DtoInterface
{
    /**
     * @description If quiz is passed, the user will be allowed to create only polls in the quiz mode. If regular is
     * passed, only regular polls will be allowed. Otherwise, the user will be allowed to create a poll of any type
     */
    public ?PollType $type = null;

    public static function makeFromArray(array $data): self
    {
        $entity = new static();

        $entity->type = ! empty($data['type']) ? new PollType($data['type']) : null;

        return $entity;
    }

    public function toArray(): array
    {
        return clean_nullable_fields([
            'type' => $this->type->getValue(),
        ]);
    }
}
