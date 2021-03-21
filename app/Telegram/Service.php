<?php

namespace App\Telegram;

use App\Commands\AbstractCommand;
use App\Commands\Actions\AbstractAction;
use App\Telegram\Dto\Message\Message;
use App\Telegram\Exception\CommandAlreadyExistsException;
use App\Telegram\Exception\UnknownRequestException;
use App\Telegram\Response\UpdateResponse;

class Service
{
    private array $commands = [];

    public function __construct()
    {
        $this->setCommands();
    }

    public function findAndHandleCommand(UpdateResponse $response): void
    {
        $commandName = $this->findCommandNameFromMessage($response->message);

        if ($commandName && array_key_exists($commandName, $this->commands)) {
            $command = $this->makeCommand($this->commands[$commandName], $response);

            $command->handle();

            return;
        }

        $action = $this->findAction($response);

        if ($action) {
            $action->handle();

            return;
        }

        throw new UnknownRequestException();
    }

    private function setCommands()
    {
        $commands = config('telegram.commands');

        /** @var string|AbstractCommand $command */
        foreach ($commands as $command) {
            $commandName = $command::getName();

            if (array_key_exists($commandName, $this->commands)) {
                throw new CommandAlreadyExistsException();
            }

            $this->commands[$commandName] = $command;
        }
    }

    private function findCommandNameFromMessage(?Message $message): ?string
    {
        if ( ! $message) {
            return null;
        }

        $command = $message->text;

        if ( ! $command || strlen($command) <= 1) {
            return null;
        }

        return substr($command, 1);
    }

    private function findAction(UpdateResponse $response): ?AbstractAction
    {
        $actions = config('telegram.actions');

        /** @var string|AbstractAction $action */
        foreach ($actions as $action) {
            /** @var AbstractAction $actionEntity */
            $actionEntity = new $action($response);

            if ($actionEntity->isSatisfied()) {
                return $actionEntity;
            }
        }

        return null;
    }

    private function makeCommand(string $commandClass, UpdateResponse $response): AbstractCommand
    {
        return new $commandClass($response);
    }
}
