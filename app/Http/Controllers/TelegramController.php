<?php

namespace App\Http\Controllers;

use App\Commands\AbstractCommand;
use App\Telegram\Facade;
use App\Telegram\Response\UpdateResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TelegramController extends Controller
{
    public function hears(Request $request, Facade $facade)
    {
        $request = $this->makeUpdateResponse($request);

        $commands = $this->getCommands($request, $facade);

        $command = $this->recognizeCommand($request, $commands);

        if ( ! $command) {
            // TODO: I don't understand!
            return '';
        }

        $command->handle();

        return '';
    }

    /**
     * @param UpdateResponse $response
     * @param Facade $facade
     * @return AbstractCommand[]
     */
    private function getCommands(UpdateResponse $response, Facade $facade): array
    {
        $commands = config('telegram.commands');

        $result = [];
        foreach ($commands as $command) {
            /** @var AbstractCommand $commandEntity */
            $commandEntity = new $command($response, $facade);

            $result[$commandEntity->getName()] = $commandEntity;
        }

        return $result;
    }

    private function makeUpdateResponse(Request $request): UpdateResponse
    {
        return new UpdateResponse($request->request->all());
    }

    /**
     * @param UpdateResponse $response
     * @param AbstractCommand[] $commands
     * @param Facade $facade
     * @return AbstractCommand|null
     */
    private function recognizeCommand(UpdateResponse $response, array $commands): ?AbstractCommand
    {
        $command = Arr::get($response->message, 'text');

        if ( ! $command || strlen($command) <= 1) {
            return null;
        }

        $command = substr($command, 1);

        if ( ! array_key_exists($command, $commands)) {
            return null;
        }

        return $commands[$command];
    }
}
