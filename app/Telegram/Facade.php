<?php

namespace App\Telegram;

use App\Telegram\Request\GetMeRequest;
use App\Telegram\Request\SendMessageRequest;
use App\Telegram\Response\GetMeResponse;
use App\Telegram\Response\SendMessageResponse;
use BadMethodCallException;

/**
 * @method GetMeResponse getMe(GetMeRequest $request)
 * @method SendMessageResponse sendMessage(SendMessageRequest $request)
 */
class Facade
{
    private const POSSIBLE_METHODS = [
        'getMe',
        'sendMessage',
    ];

    private Gate $gate;

    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    public function __call($name, $arguments)
    {
        if ( ! in_array($name, static::POSSIBLE_METHODS)) {
            throw new BadMethodCallException();
        }

        return $this->gate->call(reset($arguments));
    }
}
