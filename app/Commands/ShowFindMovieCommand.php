<?php

namespace App\Commands;

use App\Repositories\UserLastMessageRepository;

/**
 * @description Show find movie description and starts wait search string
 */
class ShowFindMovieCommand extends AbstractCommand
{
    public static function getName(): string
    {
        return 'show_find_movie';
    }

    public function handle(): void
    {
        $sendMessageResponse = $this->sendAnswerMessageWithBackButton(
            trans('main.movie_lists.find_movie_description')
        );

        if ( ! $sendMessageResponse) {
            return;
        }

        $internalUser = $this->getUserFromMessage();

        UserLastMessageRepository::getInstance()->createOrUpdate(
            $internalUser,
            $sendMessageResponse->message->id,
            static::getName()
        );
    }
}
