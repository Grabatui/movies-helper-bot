<?php

namespace App\Telegram\Dto\Field;

use App\Common\Field\AbstractField;
use App\Telegram\Dto\Enum\EncryptedPassportElementTypeEnum;

class EncryptedPassportElementType extends AbstractField
{
    protected function validate(string $value): bool
    {
        return in_array($value, EncryptedPassportElementTypeEnum::ALL);
    }
}
