<?php

namespace App\Telegram\Request;

use App\Telegram\Field\RequestMethod;
use App\Telegram\Response\ResponseInterface;

interface RequestInterface
{
    public function getMethod(): RequestMethod;

    public function getUri(): string;

    public function makeResponse(array $rawResponse): ResponseInterface;
}
