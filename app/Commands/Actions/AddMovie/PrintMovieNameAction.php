<?php

namespace App\Commands\Actions\AddMovie;

use App\Commands\Actions\AbstractAction;
use App\Commands\ShowAddMovieCommand;
use App\Models\MoviesList;
use App\Repositories\MoviesListRepository;
use App\Repositories\UserLastMessageRepository;

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
        $lastMessage = $this->getLastUserMessage(
            ShowAddMovieCommand::getName()
        );

        if ( ! $lastMessage) {
            return;
        }

        $internalUser = $this->getUserFromMessage();

        $this->selectedMoviesList = MoviesListRepository::getInstance()->getMoviesListByUserAndName(
            $internalUser,
            $this->getRequestMessage()->text
        );
    }
}
