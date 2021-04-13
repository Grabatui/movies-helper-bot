<?php

namespace App\Commands\Actions;

use App\Enum\AnswerEnum;
use App\Repositories\UserLastMessageRepository;

/**
 * @description Next page button in paginated lists
 */
class NextPageAction extends AbstractPageAction
{
    public static function getName(): string
    {
        return 'next_page';
    }

    public function isSatisfied(): bool
    {
        $internalUser = $this->getOrCreateUserFromMessage();

        if ( ! $internalUser) {
            return false;
        }

        return $this->getRequestMessage() && $this->getRequestMessage()->text === AnswerEnum::nextPage();
    }

    public function handle(): void
    {
        $lastMessage = $this->getCheckedLastUserMessage();

        if ( ! $lastMessage) {
            return;
        }

        $page = $lastMessage->data['page'] ?: 1;

        $lastMessage->data['page'] = $page + 1;

        UserLastMessageRepository::getInstance()->save($lastMessage);

        $this->handCommandByName($lastMessage->type);
    }
}
