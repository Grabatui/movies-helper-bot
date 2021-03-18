<?php

namespace App\Telegram\Dto\Field;

use App\Common\Field\AbstractField;
use App\Telegram\Dto\Enum\PollTypeEnum;

class PollType extends AbstractField
{
    protected function validate(string $value): bool
    {
        return in_array($value, PollTypeEnum::ALL);
    }
}
