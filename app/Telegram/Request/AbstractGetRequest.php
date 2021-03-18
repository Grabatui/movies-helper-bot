<?php

namespace App\Telegram\Request;

use App\Telegram\Enum\RequestMethodEnum;
use App\Telegram\Field\RequestMethod;

abstract class AbstractGetRequest implements RequestInterface
{
    public function getMethod(): RequestMethod
    {
        return new RequestMethod(RequestMethodEnum::GET);
    }

    public function toArray()
    {
        return [];
    }
}
