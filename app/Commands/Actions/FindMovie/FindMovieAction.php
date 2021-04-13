<?php

namespace App\Commands\Actions\FindMovie;

use App\Commands\Actions\AbstractAction;
use App\Commands\PrintMoviesListCommand;
use App\Commands\ShowFindMovieCommand;
use App\Models\UserLastMessage;

/**
 * @description Starts search movie
 */
class FindMovieAction extends AbstractAction
{
    private ?UserLastMessage $lastMessage = null;

    public static function getName(): string
    {
        return 'find_movie';
    }

    public function isSatisfied(): bool
    {
        $this->setLastMessage();

        return ! is_null($this->lastMessage);
    }

    public function handle(): void
    {
        if ( ! $this->lastMessage) {
            $this->setLastMessage();

            if ( ! $this->lastMessage) {
                return;
            }
        }

        $this->handleCommand(
            PrintMoviesListCommand::class
        );
    }

    private function setLastMessage(): void
    {
        $this->lastMessage = $this->getLastUserMessage(
            ShowFindMovieCommand::getName()
        );
    }
}
