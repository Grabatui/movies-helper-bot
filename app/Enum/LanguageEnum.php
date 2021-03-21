<?php

namespace App\Enum;

class LanguageEnum
{
    public const EN = 'en';
    public const RU = 'ru';

    public const ALL = [
        self::EN,
        self::RU,
    ];

    public const NAMES = [
        self::EN => 'English',
        self::RU => 'Русский',
    ];
}
