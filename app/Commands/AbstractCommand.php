<?php

namespace App\Commands;

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
}
