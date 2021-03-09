<?php

namespace App\Telegram\Dto;

use App\Telegram\Dto\Field\MessageEntityType;

class MessageEntity
{
    public MessageEntityType $type;

    public int $offset;

    public int $length;

    public string $url = '';

    public ?User $user = null;

    public string $language = '';
}
