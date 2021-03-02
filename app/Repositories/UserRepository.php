<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public static function getInstance(): self
    {
        return new static();
    }

    public function create(string $chatId, string $name, string $language): User
    {
        $user = new User();
        $user->chat_id = $chatId;
        $user->name = $name;
        $user->language = $language;

        $user->save();

        return $user;
    }

    public function getByChatId(string $chatId): ?User
    {
        return User::query()->where('chat_id', $chatId)->get()->first();
    }
}
