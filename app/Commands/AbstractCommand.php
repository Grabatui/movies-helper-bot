<?php

namespace App\Commands;

use App\Telegram\Dto\Chat\Chat;
use App\Telegram\Dto\Message\Message;
use App\Telegram\Facade;
use App\Telegram\Response\UpdateResponse;

abstract class AbstractCommand
{
    protected UpdateResponse $request;

    protected Facade $facade;

    public function __construct(UpdateResponse $request, Facade $facade)
    {
        $this->request = $request;
        $this->facade = $facade;
    }

    abstract public function getName(): string;

    abstract public function handle(): void;

    protected function getRequestMessage(): Message
    {
        return $this->request->message;
    }

    protected function getChat(): Chat
    {
        return $this->getRequestMessage()->chat;
    }
}
