<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserLastMessage;

class UserLastMessageRepository
{
    public static function getInstance(): self
    {
        return new static();
    }

    public function getByUser(User $user): ?UserLastMessage
    {
        return UserLastMessage::query()->where('user_id', $user->id)->get()->first();
    }

    public function createOrUpdate(User $user, int $messageId, string $type, array $data = [])
    {
        $exists = $this->getByUser($user);

        if ( ! $exists) {
            UserLastMessage::query()->create([
                'user_id' => $user->id,
                'message_id' => $messageId,
                'type' => $type,
                'data' => $data
            ]);
        } else {
            $exists->message_id = $messageId;
            $exists->type = $type;
            $exists->data = $data;

            $exists->save();
        }
    }

    public function save(UserLastMessage $lastMessage): void
    {
        $lastMessage->save();
    }
}
