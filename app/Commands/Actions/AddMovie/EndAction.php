<?php

namespace App\Commands\Actions\AddMovie;

use App\Commands\Actions\AbstractAction;
use App\Commands\ShowDefaultMenuCommand;
use App\Models\MoviesList;
use App\Models\UserLastMessage;
use App\Repositories\MovieRepository;
use App\Repositories\MoviesListRepository;

/**
 * @description End of the adding movie - get incoming year, add movie to the DB and show main menu
 */
class EndAction extends AbstractAction
{
    private ?UserLastMessage $userLastMessage = null;

    private ?MoviesList $moviesList = null;

    public static function getName(): string
    {
        return 'add_movie_end';
    }

    public function isSatisfied(): bool
    {
        $this->setMoviesList();

        return ! is_null($this->userLastMessage) && ! is_null($this->moviesList);
    }

    public function handle(): void
    {
        MovieRepository::getInstance()->create(
            $this->moviesList,
            $this->userLastMessage->data['name'],
            (int)$this->getRequestMessage()->text
        );

        $this->sendAnswerMessage(trans('main.movie_lists.success'));

        $this->handleCommand(
            ShowDefaultMenuCommand::class,
        );
    }

    private function setMoviesList(): void
    {
        $lastMessage = $this->getLastUserMessage(
            PrintMovieYearAction::getName()
        );

        if (
            ! $lastMessage
            || ! $lastMessage->data
            || empty($lastMessage->data['movies_list_id'])
        ) {
            return;
        }

        $this->userLastMessage = $lastMessage;

        if ( ! is_numeric($this->getRequestMessage()->text)) {
            $this->sendAnswerMessage(trans('main.errors.add_movie_year_not_numeric'));

            return;
        }

        $internalUser = $this->getOrCreateUserFromMessage();

        $this->moviesList = MoviesListRepository::getInstance()->getMoviesListByUserAndId(
            $internalUser,
            $this->userLastMessage->data['movies_list_id']
        );

        return;
    }
}
