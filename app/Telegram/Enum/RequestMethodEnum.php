<?php

namespace App\Telegram\Enum;

class RequestMethodEnum
{
    public const GET = 'GET';
    public const POST = 'POST';

    public const ALL = [
        self::GET,
        self::POST,
    ];
}
