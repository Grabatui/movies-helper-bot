<?php

namespace App\Commands\Actions;

use App\Enum\AnswerEnum;
use App\Repositories\UserLastMessageRepository;

/**
 * @description Previous page button in paginated lists
 */
class PreviousPageAction extends AbstractPageAction
{
    public static function getName(): string
    {
        return 'previous_page';
    }

    public function isSatisfied(): bool
    {
        $internalUser = $this->getOrCreateUserFromMessage();

        if ( ! $internalUser) {
            return false;
        }

        return $this->getRequestMessage() && $this->getRequestMessage()->text === AnswerEnum::previousPage();
    }

    public function handle(): void
    {
        $lastMessage = $this->getCheckedLastUserMessage();

        if ( ! $lastMessage) {
            return;
        }

        $page = $lastMessage->data['page'] ?: 1;

        $lastMessage->data['page'] = max($page - 1, 1);

        UserLastMessageRepository::getInstance()->save($lastMessage);

        $this->handCommandByName($lastMessage->type);
    }
}
