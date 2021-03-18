<?php

namespace App\Telegram\Request;

use App\Telegram\Field\RequestMethod;
use App\Telegram\Response\ResponseInterface;
use Illuminate\Contracts\Support\Arrayable;

interface RequestInterface extends Arrayable
{
    public function getMethod(): RequestMethod;

    public function getUri(): string;

    public function makeResponse(array $rawResponse): ResponseInterface;
}
