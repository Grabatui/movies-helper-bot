<?php

namespace App\Commands\Actions;

use App\Commands\PrintMoviesListCommand;
use App\Models\UserLastMessage;
use App\Repositories\UserLastMessageRepository;

abstract class AbstractPageAction extends AbstractAction
{
    protected function getCheckedLastUserMessage(): ?UserLastMessage
    {
        $user = $this->getUserFromMessage();

        $lastMessage = UserLastMessageRepository::getInstance()->getByUser($user);

        if (
            ! $lastMessage
            || ! in_array($lastMessage->type, $this->getAvailableCommandsWithPage())
        ) {
            return null;
        }

        return $lastMessage;
    }

    protected function getAvailableCommandsWithPage(): array
    {
        return [
            PrintMoviesListCommand::getName(),
        ];
    }
}
