<?php

namespace App\Telegram\Dto\Enum;

class MessageEntityTypeEnum
{
    public const MENTION = 'mention';
    public const HASHTAG = 'hashtag';
    public const CASHTAG = 'cashtag';
    public const BOT_COMMAND = 'bot_command';
    public const URL = 'url';
    public const EMAIL = 'email';
    public const PHONE_NUMBER = 'phone_number';
    public const BOLD = 'bold';
    public const ITALIC = 'italic';
    public const UNDERLINE = 'underline';
    public const STRIKETHROUGH = 'strikethrough';
    public const CODE = 'code';
    public const PRE = 'pre';
    public const TEXT_LINK = 'text_link';
    public const TEXT_MENTION = 'text_mention';

    public const ALL = [
        self::MENTION,
        self::HASHTAG,
        self::CASHTAG,
        self::BOT_COMMAND,
        self::URL,
        self::EMAIL,
        self::PHONE_NUMBER,
        self::BOLD,
        self::ITALIC,
        self::UNDERLINE,
        self::STRIKETHROUGH,
        self::CODE,
        self::PRE,
        self::TEXT_LINK,
        self::TEXT_MENTION,
    ];
}
