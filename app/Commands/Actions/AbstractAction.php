<?php

namespace App\Commands\Actions;

use App\Commands\AbstractCommand;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Telegram\Dto\Message\Message;
use App\Telegram\Dto\User as UserDto;
use App\Telegram\Facade;
use App\Telegram\Response\UpdateResponse;

abstract class AbstractAction extends AbstractCommand
{
    protected UpdateResponse $request;

    protected Facade $facade;

    abstract public function isSatisfied(): bool;

    protected function getRequestMessage(): ?Message
    {
        $message = $this->request->callbackQuery ? $this->request->callbackQuery->message : null;

        if ( ! $message) {
            $message = parent::getRequestMessage();
        }

        return $message;
    }

    protected function getRequestFrom(): ?UserDto
    {
        $requestCallbackQuery = $this->request->callbackQuery;

        if ($requestCallbackQuery && $requestCallbackQuery->from) {
            return $requestCallbackQuery->from;
        }

        return parent::getRequestFrom();
    }

    protected function getUserFromCallbackQuery(): ?User
    {
        $checkRequestCallbackQuery = $this->request->callbackQuery;

        if ( ! $checkRequestCallbackQuery || ! $checkRequestCallbackQuery->from) {
            return null;
        }

        return UserRepository::getInstance()->getByExternalId(
            $checkRequestCallbackQuery->from->id
        );
    }
}
