<?php

namespace App\Telegram\Dto\Keyboard;

use App\Telegram\Dto\DtoInterface;

/**
 * @description A placeholder, currently holds no information. Use BotFather to set up your game
 */
class CallbackGame implements DtoInterface
{
    public static function makeFromArray(array $data): DtoInterface
    {
        return new static();
    }

    public function toArray()
    {
        return [];
    }
}
