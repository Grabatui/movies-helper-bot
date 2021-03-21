<?php

namespace App\Telegram\Dto\Keyboard;

use App\Telegram\Dto\DtoInterface;

/**
 * @description Contains buttons in row
 *
 * @custom
 */
class KeyboardButtonsRow implements DtoInterface
{
    /**
     * @var KeyboardButton[]
     */
    public array $buttons = [];

    public function __construct(array $buttons = [])
    {
        $this->buttons = $buttons;
    }

    public static function makeFromArray(array $data): self
    {
        $buttons = arrays_to_array_of_objects($data, KeyboardButton::class);

        return new static($buttons);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_map(
            fn(KeyboardButton $button) => $button->toArray(),
            $this->buttons
        );
    }

    public function add(KeyboardButton $button): void
    {
        $this->buttons[] = $button;
    }
}
