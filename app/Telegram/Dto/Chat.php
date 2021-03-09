<?php

namespace App\Telegram\Dto;

use App\Telegram\Dto\Field\ChatType;

class Chat
{
    public int $id;

    public ChatType $type;

    public string $title = '';

    public string $username = '';

    public string $firstName = '';

    public string $lastName = '';

    public ?ChatPhoto $photo = null;

    public string $biography = '';

    public string $description = '';

    public string $inviteLink = '';

    public ?Message $pinnedMessage = null;

    public ?ChatPermissions $permissions = null;

    public int $slowModeDelay = 0;

    public string $stickerSetName = '';

    public bool $canSetStickerName = false;

    public int $linkedChatId = 0;

    public ?ChatLocation $location = null;
}
