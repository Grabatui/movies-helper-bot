<?php

namespace App\Commands;

use App\Enum\AnswerEnum;
use App\Models\Movie;
use App\Models\UserLastMessage;
use App\Repositories\Entity\MovieSearchParameters;
use App\Repositories\MovieRepository;
use App\Telegram\Dto\Keyboard\KeyboardButton;
use App\Telegram\Dto\Keyboard\KeyboardButtonsRow;
use App\Telegram\Dto\Keyboard\ReplyKeyboardMarkup;
use App\Telegram\Request\SendMessageRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * @description Prints movies list to use (delete, set as watched, etc.)
 */
class PrintMoviesListCommand extends AbstractCommand
{
    private const PAGE_LIMIT = 6;

    public static function getName(): string
    {
        return 'print_movies_list';
    }

    public function handle(): void
    {
        $lastMessage = $this->getLastUserMessage(
            ShowFindMovieCommand::getName()
        );

        if ( ! $lastMessage) {
            return;
        }

        $searchParameters = $this->getMovieSearchParameters($lastMessage);

        $movies = MovieRepository::getInstance()->search($searchParameters);

        $sendMessageRequest = $this->makeSendMessageRequest($movies);

        $this->facade->sendMessage($sendMessageRequest);
    }

    private function getMovieSearchParameters(UserLastMessage $lastMessage)
    {
        $page = $lastMessage->data['page'] ?? 1;

        $searchParameters = new MovieSearchParameters(
            $this->getRequestMessage()->text
        );

        $searchParameters->setPage($page, static::PAGE_LIMIT);

        return $searchParameters;
    }

    /**
     * @param LengthAwarePaginator|Collection $movies
     * @return SendMessageRequest
     */
    private function makeSendMessageRequest(LengthAwarePaginator $movies): SendMessageRequest
    {
        $movies->load('moviesList');

        $keyboard = $movies
            // By two movies in row
            ->chunk(static::PAGE_LIMIT / 2)
            ->transform(function (Collection $rowMovies): KeyboardButtonsRow {
                return $rowMovies->reduce(function (KeyboardButtonsRow $carry, Movie $movie) {
                    $carry->add(
                        new KeyboardButton($movie->getFullName())
                    );

                    return $carry;
                }, new KeyboardButtonsRow());
            })
            ->toArray();

        $keyboard[] = $this->getPagesRow($movies);

        $keyboard[] = $this->getBackKeyboardButtonRow();

        $request = new SendMessageRequest($this->getRequestChat(), '');

        $request->replyMarkup = new ReplyKeyboardMarkup($keyboard);
        $request->replyMarkup->oneTimeKeyboard = true;

        return $request;
    }

    private function getPagesRow(LengthAwarePaginator $movies): KeyboardButtonsRow
    {
        $pagesRow = new KeyboardButtonsRow();

        // Has previous page
        if ($movies->currentPage() > 1) {
            $pagesRow->add(
                new KeyboardButton(AnswerEnum::previousPage())
            );
        }

        // Has next page
        if ($movies->hasMorePages()) {
            $pagesRow->add(
                new KeyboardButton(AnswerEnum::nextPage())
            );
        }

        return $pagesRow;
    }
}
