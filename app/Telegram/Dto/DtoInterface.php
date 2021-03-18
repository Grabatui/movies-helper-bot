<?php

namespace App\Telegram\Dto;

use Illuminate\Contracts\Support\Arrayable;

interface DtoInterface extends Arrayable
{
    public static function makeFromArray(array $data): self;
}
