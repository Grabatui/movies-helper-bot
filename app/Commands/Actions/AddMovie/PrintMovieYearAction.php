<?php

namespace App\Commands\Actions\AddMovie;

use App\Commands\Actions\AbstractAction;
use App\Models\UserLastMessage;
use App\Repositories\UserLastMessageRepository;

/**
 * @description Set printed new movie's name in the DB and ask for the movie's year
 */
class PrintMovieYearAction extends AbstractAction
{
    private ?UserLastMessage $userLastMessage = null;

    public static function getName(): string
    {
        return 'add_movie_print_year';
    }

    public function isSatisfied(): bool
    {
        $this->setMoviesList();

        return ! is_null($this->userLastMessage);
    }

    public function handle(): void
    {
        if ( ! $this->userLastMessage) {
            $this->setMoviesList();

            if ( ! $this->userLastMessage) {
                return;
            }
        }

        $this->userLastMessage->type = static::getName();
        $this->userLastMessage->data = array_merge(
            $this->userLastMessage->data ?: [],
            ['name' => $this->getRequestMessage()->text]
        );

        UserLastMessageRepository::getInstance()->save($this->userLastMessage);

        $this->sendAnswerMessageWithBackButton(
            trans('main.movie_lists.print_movie_year')
        );
    }

    private function setMoviesList(): void
    {
        if ( ! $this->getRequestMessage() || ! $this->getRequestMessage()->text) {
            return;
        }

        $internalUser = $this->getOrCreateUserFromMessage();

        if ( ! $internalUser) {
            return;
        }

        $lastMessage = UserLastMessageRepository::getInstance()->getByUser(
            $internalUser
        );

        if (! $lastMessage || $lastMessage->type !== PrintMovieNameAction::getName()) {
            return;
        }

        $this->userLastMessage = $lastMessage;
    }
}
