<?php

namespace App\Commands;

use App\Enum\AnswerEnum;
use App\Enum\LanguageEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Telegram\Dto\Chat\Chat;
use App\Telegram\Dto\Keyboard\KeyboardButton;
use App\Telegram\Dto\Keyboard\KeyboardButtonsRow;
use App\Telegram\Dto\Keyboard\ReplyKeyboardMarkup;
use App\Telegram\Dto\Message\Message;
use App\Telegram\Dto\User as UserDto;
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

    protected function handleCommand(string $commandClassName): void
    {
        app(Service::class)->handleCommandByClassName($commandClassName, $this->request);
    }

    protected function handCommandByName(string $commandName): void
    {
        app(Service::class)->handleCommandByName($commandName, $this->request);
    }

    protected function getRequestMessage(): ?Message
    {
        $message = $this->request->message;

        if ( ! $message) {
            $message = $this->request->callbackQuery ? $this->request->callbackQuery->message : null;
        }

        return $message;
    }

    protected function sendAnswerMessage(string $message): void
    {
        if ( ! $this->getRequestChat()) {
            return;
        }

        $this->facade->sendMessage(
            new SendMessageRequest($this->getRequestChat(), $message)
        );
    }

    protected function sendAnswerMessageWithBackButton(string $message): void
    {
        if ( ! $this->getRequestChat()) {
            return;
        }

        $request = new SendMessageRequest($this->getRequestChat(), $message);

        $request->replyMarkup = new ReplyKeyboardMarkup([
            $this->getBackKeyboardButtonRow()
        ]);

        $request->replyMarkup->oneTimeKeyboard = true;

        $this->facade->sendMessage($request);
    }

    protected function getUserFromMessage(): ?User
    {
        $chat = $this->getRequestChat();

        if ( ! $chat) {
            return null;
        }

        return UserRepository::getInstance()->getByExternalId(
            $chat->id
        );
    }

    protected function getRequestFrom(): ?UserDto
    {
        $checkRequestMessage = $this->getRequestMessage();

        $from = $checkRequestMessage ? $checkRequestMessage->from : null;

        if ( ! $from) {
            $requestCallbackQuery = $this->request->callbackQuery;

            if ($requestCallbackQuery && $requestCallbackQuery->from) {
                return $requestCallbackQuery->from;
            }
        }

        return $from;
    }

    protected function getRequestChat(): ?Chat
    {
        $checkRequestMessage = $this->getRequestMessage();

        return $checkRequestMessage ? $checkRequestMessage->chat : null;
    }

    protected function getOrCreateUserFromMessage(): ?User
    {
        $from = $this->getRequestFrom();
        $chat = $this->getRequestChat();

        if ( ! $from || ! $chat) {
            return null;
        }

        $internalUser = $this->getUserFromMessage();

        if ( ! $internalUser) {
            $internalUser = UserRepository::getInstance()->create(
                $chat->id,
                $chat->id,
                $from->username,
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

    protected function getBackKeyboardButtonRow(): KeyboardButtonsRow
    {
        return new KeyboardButtonsRow([
            new KeyboardButton(AnswerEnum::back())
        ]);
    }
}
