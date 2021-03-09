<?php

namespace App\Telegram\Request;

use App\Telegram\Enum\RequestMethodEnum;
use App\Telegram\Field\RequestMethod;

abstract class AbstractPostRequest implements RequestInterface
{
    public function getMethod(): RequestMethod
    {
        return new RequestMethod(RequestMethodEnum::POST);
    }

    public function getRequestData(): array
    {
        return [];
    }
}
