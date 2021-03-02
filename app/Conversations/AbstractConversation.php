<?php

namespace App\Conversations;

use App\Models\User;
use App\Repositories\UserRepository;
use BotMan\BotMan\Messages\Conversations\Conversation;

abstract class AbstractConversation extends Conversation
{
    protected function getUserByChatId(): ?User
    {
        return UserRepository::getInstance()->getByChatId(
            $this->getBot()->getUser()->getId()
        );
    }
}
