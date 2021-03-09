<?php

namespace App\Telegram\Dto\Enum;

class ChatTypeEnum
{
    public const PRIVATE = 'private';
    public const GROUP = 'group';
    public const SUPER_GROUP = 'supergroup';
    public const CHANNEL = 'channel';

    public const ALL = [
        self::PRIVATE,
        self::GROUP,
        self::SUPER_GROUP,
        self::CHANNEL,
    ];
}
