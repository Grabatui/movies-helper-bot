<?php

namespace App\Telegram\Dto\Enum;

class ChatMemberStatusEnum
{
    public const CREATOR = 'creator';
    public const ADMINISTRATOR = 'administrator';
    public const MEMBER = 'member';
    public const RESTRICTED = 'restricted';
    public const LEFT = 'left';
    public const KICKED = 'kicked';

    public const ALL = [
        self::CREATOR,
        self::ADMINISTRATOR,
        self::MEMBER,
        self::RESTRICTED,
        self::LEFT,
        self::KICKED,
    ];
}
