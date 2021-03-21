<?php

namespace App\Commands\Actions;

use App\Commands\AbstractCommand;
use App\Telegram\Facade;
use App\Telegram\Response\UpdateResponse;

abstract class AbstractAction extends AbstractCommand
{
    protected UpdateResponse $request;

    protected Facade $facade;

    abstract public function isSatisfied(): bool;
}
