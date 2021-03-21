<?php

namespace App\Commands;

use App\Enum\LanguageEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Telegram\Dto\Chat\Chat;
use App\Telegram\Dto\Message\Message;
use App\Telegram\Exception\UnknownCommandException;
use App\Telegram\Facade;
use App\Telegram\Request\SendMessageRequest;
use App\Telegram\Response\UpdateResponse;

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
        if (
            ! in_array($commandName, config('telegram.commands'))
            && ! in_array($commandName, config('telegram.actions'))
        ) {
            throw new UnknownCommandException();
        }

        /** @var AbstractCommand $command */
        $command = new $commandName($this->request);

        $command->handle();
    }

    protected function getRequestMessage(): ?Message
    {
        return $this->request->message;
    }

    protected function getRequestCallbackQueryMessage(): ?Message
    {
        return $this->request->callbackQuery ? $this->request->callbackQuery->message : null;
    }

    protected function getChat(): ?Chat
    {
        $message = $this->getRequestMessage() ?: $this->getRequestCallbackQueryMessage();

        return $message ? $message->chat : null;
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

    protected function getUserFromCallbackQuery(): ?User
    {
        $checkRequestCallbackQuery = $this->request->callbackQuery;

        if ( ! $checkRequestCallbackQuery || ! $checkRequestCallbackQuery->from) {
            return null;
        }

        return UserRepository::getInstance()->getByExternalUserId(
            $checkRequestCallbackQuery->from->id
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

    protected function getOrCreateUserFromCallbackQuery(): ?User
    {
        $checkRequestCallbackQuery = $this->request->callbackQuery;

        if ( ! $checkRequestCallbackQuery || ! $checkRequestCallbackQuery->from) {
            return null;
        }

        $requestBotMessage = $this->getRequestCallbackQueryMessage();

        if ( ! $requestBotMessage) {
            return null;
        }

        $internalUser = $this->getUserFromCallbackQuery();

        if ( ! $internalUser) {
            $internalUser = UserRepository::getInstance()->create(
                $requestBotMessage->chat->id,
                $checkRequestCallbackQuery->from->id,
                $checkRequestCallbackQuery->from->username,
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
