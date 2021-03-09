<?php

namespace App\Telegram\Response;

interface ResponseInterface
{
    public function __construct(array $rawResponse);
}
