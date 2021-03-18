<?php

namespace App\Telegram\Dto\Enum;

class PollTypeEnum
{
    public const REGULAR = 'regular';
    public const QUIZ = 'quiz';

    public const ALL = [
        self::REGULAR,
        self::QUIZ,
    ];
}
