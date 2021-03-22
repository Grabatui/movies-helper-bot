<?php

namespace App\Commands;

use App\Enum\LanguageEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Telegram\Dto\Chat\Chat;
use App\Telegram\Dto\Message\Message;
use App\Telegram\Facade;
use App\Telegram\Request\SendMessageRequest;
use App\Telegram\Response\UpdateResponse;
use App\Telegram\Service;

abstract class AbstractCommand
{
    protected UpdateResponse $request;

    protected Facade $facade;

    public function __construct(UpdateResponse $request)
    {
        $this->request = $request;
        $this->facade = app(Facade::class);

        app('translator')->setLocale(LanguageEnum::EN);
    }

    abstract public static function getName(): string;

    abstract public function handle(): void;

    protected function handleCommand(string $commandName): void
    {
        app(Service::class)->handleCommandByName($commandName, $this->request);
    }

    protected function getRequestMessage(): ?Message
    {
        return $this->request->message;
    }

    protected function getChat(): ?Chat
    {
        return $this->getRequestMessage() ? $this->getRequestMessage()->chat : null;
    }

    protected function sendAnswerMessage(string $message): void
    {
        if ( ! $this->getChat()) {
            return;
        }

        $this->facade->sendMessage(
            new SendMessageRequest($this->getChat(), $message)
        );
    }

    protected function getUserFromMessage(): ?User
    {
        $checkRequestMessage = $this->getRequestMessage();

        if ( ! $checkRequestMessage || ! $checkRequestMessage->from) {
            return null;
        }

        return UserRepository::getInstance()->getByExternalUserId(
            $checkRequestMessage->from->id
        );
    }

    protected function getOrCreateUserFromMessage(): ?User
    {
        $checkRequestMessage = $this->getRequestMessage();

        if ( ! $checkRequestMessage || ! $checkRequestMessage->from || ! $checkRequestMessage->chat) {
            return null;
        }

        $internalUser = $this->getUserFromMessage();

        if ( ! $internalUser) {
            $internalUser = UserRepository::getInstance()->create(
                $checkRequestMessage->chat->id,
                $checkRequestMessage->from->id,
                $checkRequestMessage->from->username,
                LanguageEnum::EN
            );
        }

        $this->setLanguage($internalUser->language);

        return $internalUser;
    }

    protected function setLanguage(string $language): void
    {
        app('translator')->setLocale($language);
    }
}
