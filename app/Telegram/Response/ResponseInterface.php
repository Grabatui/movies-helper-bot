<?php

namespace App\Telegram\Response;

use Illuminate\Contracts\Support\Arrayable;

interface ResponseInterface extends Arrayable
{
    public function __construct(array $rawResponse);
}
