<?php

namespace App\Enum;

class AnswerEnum
{
    public static function back(): string
    {
        return '⬅️ ' . trans('main.back');
    }

    public static function nextPage(): string
    {
        return trans('main.next_page') . '➡️';
    }

    public static function previousPage(): string
    {
        return '⬅️ ' . trans('main.previous_page');
    }
}
