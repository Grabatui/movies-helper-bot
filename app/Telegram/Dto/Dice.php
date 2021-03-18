<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents an animated emoji that displays a random value
 *
 * @see https://core.telegram.org/bots/api#dice
 */
class Dice implements DtoInterface
{
    /**
     * @description Emoji on which the dice throw animation is based
     */
    public string $emoji;

    /**
     * @description Value of the dice, 1-6 for “🎲”, “🎯” and “🎳” base emoji, 1-5 for “🏀” and “⚽” base emoji, 1-64 for
     * “🎰” base emoji
     */
    public int $value;

    public function __construct(string $emoji, int $value)
    {
        $this->emoji = $emoji;
        $this->value = $value;
    }

    public static function makeFromArray(array $data): self
    {
        return new static(
            $data['emoji'],
            $data['value']
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'emoji' => $this->emoji,
            'value' => $this->value,
        ];
    }
}
