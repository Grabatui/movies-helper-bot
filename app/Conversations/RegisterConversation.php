<?php

namespace App\Conversations;

use App\Repositories\UserRepository;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class RegisterConversation extends AbstractConversation
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $user = $this->getUserByChatId();

        if ( $user) {
            $this->getBot()->startConversation(
                new MainActionsConversation()
            );

            return;
        }

        $this->askLanguage();
    }

    private function askLanguage(): void
    {
        $question = Question::create('Hello there! What language do you prefer?')
            ->fallback('Goodbye there!')
            ->callbackId('language_choose')
            ->addButtons([
                Button::create('\xF0\x9F\x87\xBA\xF0\x9F\x87\xB8 English')->value('en'),
                Button::create('\xF0\x9F\x87\xB7\xF0\x9F\x87\xBA Russian')->value('ru'),
            ]);

        $this->ask($question, function (Answer $answer): void {
            if ( ! $answer->isInteractiveMessageReply()) {
                return;
            }

            $this->askName($answer->getValue());
        });
    }

    private function askName(string $language): void
    {
        $question = Question::create(trans('Как Вас зовут?', [], $language))
            ->fallback('Goodbye there!')
            ->callbackId('get_name');

        $this->ask($question, function (Answer $answer) use ($language): void {
            if ($answer->isInteractiveMessageReply()) {
                return;
            }

            $this->makeUser($answer->getValue(), $language);

            $this->say(trans('Привет, :name!', ['name' => $answer->getValue()], $language));

            $this->say(trans('Поздравляем! Вы можете начать пользоваться сервисом', [], $language));

            $this->getBot()->startConversation(
                new MainActionsConversation()
            );
        });
    }

    private function makeUser(string $name, string $language): void
    {
        UserRepository::getInstance()->create(
            $this->getBot()->getUser()->getId(),
            $name,
            $language
        );
    }
}
