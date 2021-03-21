<?php

namespace App\Telegram\Dto\Keyboard;

/**
 * @description This object represents a custom keyboard with reply options
 *
 * @see https://core.telegram.org/bots/api#replykeyboardmarkup
 */
class ReplyKeyboardMarkup implements KeyboardMarkupInterface
{
    /**
     * @var KeyboardButtonsRow[]
     *
     * @description Array of button rows, each represented by an Array of KeyboardButton objects
     */
    public array $keyboard = [];

    /**
     * @description Requests clients to resize the keyboard vertically for optimal fit (e.g., make the keyboard smaller
     * if there are just two rows of buttons). Defaults to false, in which case the custom keyboard is always of the
     * same height as the app's standard keyboard.
     */
    public ?bool $resizeKeyboard = null;

    /**
     * @description Requests clients to hide the keyboard as soon as it's been used. The keyboard will still be
     * available, but clients will automatically display the usual letter-keyboard in the chat – the user can press a
     * special button in the input field to see the custom keyboard again. Defaults to false.
     */
    public ?bool $oneTimeKeyboard = null;

    /**
     * @description Use this parameter if you want to show the keyboard to specific users only. Targets: 1) users that
     * are @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id),
     * sender of the original message.
     */
    public ?bool $selective = null;

    public function __construct(array $keyboard)
    {
        $this->keyboard = $keyboard;
    }

    public static function makeFromArray(array $data): self
    {
        $inlineKeyboard = [];
        if ( ! empty($data['keyboard'])) {
            foreach ($data['keyboard'] as $buttonsRow) {
                $inlineKeyboard[] = new KeyboardButtonsRow($buttonsRow);
            }
        }

        $entity = new static($inlineKeyboard);

        $entity->resizeKeyboard = $data['resize_keyboard'] ?? null;
        $entity->oneTimeKeyboard = $data['one_time_keyboard'] ?? null;
        $entity->selective = $data['selective'] ?? null;

        return $entity;
    }

    public function toArray(): array
    {
        return array_merge(
            [
                'keyboard' => array_map(
                    fn(KeyboardButtonsRow $keyboardButtonsRow) => $keyboardButtonsRow->toArray(),
                    $this->keyboard
                ),
            ],
            clean_nullable_fields([
                'resize_keyboard' => $this->resizeKeyboard,
                'one_time_keyboard' => $this->oneTimeKeyboard,
                'selective' => $this->selective,
            ])
        );
    }
}
