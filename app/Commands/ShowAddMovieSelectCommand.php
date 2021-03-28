<?php

namespace App\Commands;

use App\Models\MoviesList;
use App\Repositories\MoviesListRepository;
use App\Repositories\UserLastMessageRepository;
use App\Telegram\Dto\Keyboard\KeyboardButton;
use App\Telegram\Dto\Keyboard\KeyboardButtonsRow;
use App\Telegram\Dto\Keyboard\ReplyKeyboardMarkup;
use App\Telegram\Request\SendMessageRequest;
use Illuminate\Database\Eloquent\Collection;

/**
 * @description Start process for adding movie to the user's list. Starts with movie list choosing
 */
class ShowAddMovieSelectCommand extends AbstractCommand
{
    public static function getName(): string
    {
        return 'show_add_movie_command';
    }

    public function handle(): void
    {
        $internalUser = $this->getOrCreateUserFromMessage();

        if ( ! $internalUser) {
            return;
        }

        $moviesLists = MoviesListRepository::getInstance()->getAllByUser($internalUser);

        $request = $this->makeListsRequest($moviesLists);

        $sendMessageResponse = $this->facade->sendMessage($request);

        if ($sendMessageResponse->message) {
            UserLastMessageRepository::getInstance()->createOrUpdate(
                $internalUser,
                $sendMessageResponse->message->id,
                static::getName()
            );
        }
    }

    private function makeListsRequest(Collection $moviesLists): SendMessageRequest
    {
        $request = new SendMessageRequest($this->getRequestChat(), trans('main.movie_lists.select_list'));

        $buttons = [];
        foreach ($moviesLists->chunk(4) as $moviesListsPart) {
            $row = new KeyboardButtonsRow();

            /** @var MoviesList $moviesList */
            foreach ($moviesListsPart as $moviesList) {
                $row->add(
                    new KeyboardButton($moviesList->name)
                );
            }

            $buttons[] = $row;
        }

        $buttons[] = $this->getBackKeyboardButtonRow();

        $request->replyMarkup = new ReplyKeyboardMarkup($buttons);

        $request->replyMarkup->oneTimeKeyboard = true;

        return $request;
    }
}
