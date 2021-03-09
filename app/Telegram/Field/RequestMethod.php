<?php

namespace App\Telegram\Field;

use App\Common\Field\AbstractField;
use App\Telegram\Enum\RequestMethodEnum;

class RequestMethod extends AbstractField
{
    protected function validate(string $value): bool
    {
        return in_array($value, RequestMethodEnum::ALL);
    }
}
