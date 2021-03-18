<?php

namespace App\Telegram\Dto\Keyboard;

/**
 * @description This object represents an inline keyboard that appears right next to the message it belongs to
 *
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
class InlineKeyboardMarkup implements KeyboardMarkupInterface
{
    /**
     * @var InlineKeyboardButtonsRow[]
     *
     * @description Array of button rows, each represented by an Array of InlineKeyboardButton objects
     */
    public array $inlineKeyboard = [];

    public function __construct(array $inlineKeyboard)
    {
        $this->inlineKeyboard = $inlineKeyboard;
    }

    public static function makeFromArray(array $data): self
    {
        $inlineKeyboard = [];
        if ( ! empty($data['inline_keyboard'])) {
            foreach ($data['inline_keyboard'] as $buttonsRow) {
                $inlineKeyboard[] = new InlineKeyboardButtonsRow($buttonsRow);
            }
        }

        return new static($inlineKeyboard);
    }

    public function toArray(): array
    {
        return [
            'inline_keyboard' => array_map(
                fn(InlineKeyboardButtonsRow $inlineKeyboardButtonsRow) => $inlineKeyboardButtonsRow->toArray(),
                $this->inlineKeyboard
            ),
        ];
    }
}
