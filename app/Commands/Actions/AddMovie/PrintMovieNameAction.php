<?php

namespace App\Commands\Actions\AddMovie;

use App\Commands\Actions\AbstractAction;
use App\Commands\ShowAddMovieSelectCommand;
use App\Models\MoviesList;
use App\Repositories\MoviesListRepository;
use App\Repositories\UserLastMessageRepository;
use App\Telegram\Dto\Keyboard\ReplyKeyboardMarkup;
use App\Telegram\Request\SendMessageRequest;

/**
 * @description Set selected movies list in the DB and ask for the movie's name
 */
class PrintMovieNameAction extends AbstractAction
{
    private ?MoviesList $selectedMoviesList = null;

    public static function getName(): string
    {
        return 'add_movie_print_name';
    }

    public function isSatisfied(): bool
    {
        $this->setMoviesList();

        return ! is_null($this->selectedMoviesList);
    }

    public function handle(): void
    {
        if ( ! $this->selectedMoviesList) {
            $this->setMoviesList();

            if ( ! $this->selectedMoviesList) {
                return;
            }
        }

        UserLastMessageRepository::getInstance()->createOrUpdate(
            $this->getOrCreateUserFromMessage(),
            $this->getRequestMessage()->id,
            static::getName(),
            ['movies_list_id' => $this->selectedMoviesList->id]
        );

        $this->sendAnswerMessageWithBackButton(
            trans('main.movie_lists.print_movie_name')
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

        if (! $lastMessage || $lastMessage->type !== ShowAddMovieSelectCommand::getName()) {
            return;
        }

        $this->selectedMoviesList = MoviesListRepository::getInstance()->getMoviesListByUserAndName(
            $internalUser,
            $this->getRequestMessage()->text
        );
    }
}
