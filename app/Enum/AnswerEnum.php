<?php

namespace App\Enum;

class AnswerEnum
{
    public static function back(): string
    {
        return '⬅️ ' . trans('main.back');
    }
}
