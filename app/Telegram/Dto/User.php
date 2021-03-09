<?php

namespace App\Telegram\Dto;

class User
{
    public int $id;

    public bool $isBot;

    public string $firstName;

    public string $lastName = '';

    public string $username = '';

    public string $languageCode = '';

    public bool $canJoinGroups = false;

    public bool $canReadAllGroupMessages = false;

    public bool $supportsInlineQueries = false;
}
