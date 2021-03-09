<?php

namespace App\Telegram\Request;

use App\Telegram\Response\GetMeResponse;
use App\Telegram\Response\ResponseInterface;

class GetMeRequest extends AbstractGetRequest
{
    public function getUri(): string
    {
        return '/getMe';
    }

    public function makeResponse(array $rawResponse): ResponseInterface
    {
        return new GetMeResponse($rawResponse);
    }
}
