<?php

namespace App\Commands;

use App\Models\MoviesList;
use App\Repositories\MovieListsRepository;
use App\Telegram\Dto\Keyboard\KeyboardButton;
use App\Telegram\Dto\Keyboard\KeyboardButtonsRow;
use App\Telegram\Dto\Keyboard\ReplyKeyboardMarkup;
use App\Telegram\Request\SendMessageRequest;
use Illuminate\Database\Eloquent\Collection;

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

        $moviesLists = MovieListsRepository::getInstance()->getAllByUser($internalUser);

        $request = $this->makeListsRequest($moviesLists);

        $this->facade->sendMessage($request);
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

        $buttons[] = new KeyboardButtonsRow([
            new KeyboardButton('⬅️ ' . trans('main.back'))
        ]);

        $request->replyMarkup = new ReplyKeyboardMarkup($buttons);

        $request->replyMarkup->oneTimeKeyboard = true;

        return $request;
    }
}
