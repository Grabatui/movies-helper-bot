<?php

namespace App\Common\Field;

use RuntimeException;

abstract class AbstractField
{
    protected string $value;

    public function __construct(string $value)
    {
        if ( ! $this->validate($value)) {
            $exceptionClass = $this->getExceptionClass();

            throw new $exceptionClass();
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    abstract protected function validate(string $value): bool;

    protected function getExceptionClass(): string
    {
        return RuntimeException::class;
    }
}
