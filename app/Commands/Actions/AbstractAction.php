<?php

namespace App\Commands\Actions;

use App\Commands\AbstractCommand;
use App\Enum\LanguageEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Telegram\Dto\Message\Message;
use App\Telegram\Facade;
use App\Telegram\Response\UpdateResponse;

abstract class AbstractAction extends AbstractCommand
{
    protected UpdateResponse $request;

    protected Facade $facade;

    abstract public function isSatisfied(): bool;

    protected function getRequestMessage(): ?Message
    {
        return $this->request->callbackQuery ? $this->request->callbackQuery->message : null;
    }

    protected function getOrCreateUserFromMessage(): ?User
    {
        $checkRequestCallbackQuery = $this->request->callbackQuery;

        if ( ! $checkRequestCallbackQuery || ! $checkRequestCallbackQuery->from) {
            return null;
        }

        $requestBotMessage = $this->getRequestMessage();

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
}
