<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public static function getInstance(): self
    {
        return new static();
    }

    public function create(string $chatId, int $externalId, string $name, string $language): User
    {
        $user = new User();
        $user->chat_id = $chatId;
        $user->external_id = $externalId;
        $user->name = $name;
        $user->language = $language;

        $user->save();

        return $user;
    }

    public function getByExternalUserId(int $userId): ?User
    {
        return User::query()->where('external_id', $userId)->get()->first();
    }

    public function getByChatId(string $chatId): ?User
    {
        return User::query()->where('chat_id', $chatId)->get()->first();
    }
}
