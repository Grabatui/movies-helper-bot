<?php

namespace App\Commands\Actions;

use App\Commands\ShowDefaultMenuCommand;
use App\Enum\AnswerEnum;

/**
 * @description Back button for many actions
 */
class BackAction extends AbstractAction
{
    public static function getName(): string
    {
        return 'back';
    }

    public function isSatisfied(): bool
    {
        $internalUser = $this->getOrCreateUserFromMessage();

        if ( ! $internalUser) {
            return false;
        }

        return $this->getRequestMessage() && $this->getRequestMessage()->text === AnswerEnum::back();
    }

    public function handle(): void
    {
        $this->handleCommand(
            ShowDefaultMenuCommand::class,
        );
    }
}
