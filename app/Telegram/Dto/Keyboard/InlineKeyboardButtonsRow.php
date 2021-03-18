<?php

namespace App\Telegram\Dto\Keyboard;

use App\Telegram\Dto\DtoInterface;

/**
 * @description Contains buttons in row
 *
 * @custom
 */
class InlineKeyboardButtonsRow implements DtoInterface
{
    /**
     * @var InlineKeyboardButton[]
     */
    public array $buttons = [];

    public function __construct(array $buttons = [])
    {
        $this->buttons = $buttons;
    }

    public static function makeFromArray(array $data): self
    {
        return new static($data);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_map(
            fn(InlineKeyboardButton $button) => $button->toArray(),
            $this->buttons
        );
    }

    public function add(InlineKeyboardButton $button): void
    {
        $this->buttons[] = $button;
    }
}
