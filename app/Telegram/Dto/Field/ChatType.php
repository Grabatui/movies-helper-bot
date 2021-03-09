<?php

namespace App\Telegram\Dto\Field;

use App\Common\Field\AbstractField;
use App\Telegram\Dto\Enum\ChatTypeEnum;

class ChatType extends AbstractField
{
    protected function validate(string $value): bool
    {
        return in_array($value, ChatTypeEnum::ALL);
    }
}
