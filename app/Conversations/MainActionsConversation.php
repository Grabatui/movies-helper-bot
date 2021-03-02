<?php

namespace App\Conversations;

use App\Conversations\Movie\AddListConversation;
use App\Conversations\Movie\AddMovieConversation;
use App\Conversations\Movie\FindMovieConversation;
use App\Conversations\Movie\ListMoviesConversation;
use App\Conversations\Movie\ListsConversation;
use App\Models\User;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class MainActionsConversation extends AbstractConversation
{
    private const ADD_MOVIE = 'add_movie';
    private const FIND_MOVIE = 'find_movie';
    private const LIST_MOVIES = 'list_movies';
    private const ADD_LIST = 'add_list';
    private const LISTS = 'lists';

    /**
     * @inheritDoc
     */
    public function run()
    {
        $user = $this->getUserByChatId();

        if ( ! $user) {
            $this->getBot()->startConversation(
                new RegisterConversation()
            );

            return;
        }

        $this->showMainActions($user);
    }

    private function showMainActions(User $user): void
    {
        $question = Question::create(trans('Выберите действие', [], $user->language))
            ->fallback('Goodbye there')
            ->callbackId('choose_main_action')
            ->addButtons([
                Button::create(trans('Добавить фильм', [], $user->language))->value(static::ADD_MOVIE),
                Button::create(trans('Найти фильм', [], $user->language))->value(static::FIND_MOVIE),
                Button::create(trans('Фильмы в списке', [], $user->language))->value(static::LIST_MOVIES),
                Button::create(trans('Добавить список', [], $user->language))->value(static::ADD_LIST),
                Button::create(trans('Списки', [], $user->language))->value(static::LISTS),
            ]);

        $this->ask($question, function (Answer $answer): void {
            if ($answer->isInteractiveMessageReply()) {
                return;
            }

            switch ($answer->getValue()) {
                case static::ADD_MOVIE:
                    $conversation = new AddMovieConversation();
                    break;

                case static::FIND_MOVIE:
                    $conversation = new FindMovieConversation();
                    break;

                case static::LIST_MOVIES:
                    $conversation = new ListMoviesConversation();
                    break;

                case static::ADD_LIST:
                    $conversation = new AddListConversation();
                    break;

                case static::LISTS:
                    $conversation = new ListsConversation();
                    break;

                default:
                    return;
            }

            $this->getBot()->startConversation(
                $conversation
            );
        });
    }
}
