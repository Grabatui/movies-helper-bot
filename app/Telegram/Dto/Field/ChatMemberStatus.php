<?php

namespace App\Telegram\Dto\Field;

use App\Common\Field\AbstractField;
use App\Telegram\Dto\Enum\ChatMemberStatusEnum;

class ChatMemberStatus extends AbstractField
{
    protected function validate(string $value): bool
    {
        return in_array($value, ChatMemberStatusEnum::ALL);
    }
}
