<?php

use App\Telegram\Dto\DtoInterface;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @param mixed[] $array
 * @return mixed[]
 */
function clean_nullable_fields(array $array): array
{
    return array_filter(
        $array,
        fn($item) => ! is_null($item)
    );
}

/**
 * @param Arrayable[] $array
 * @return mixed[]
 */
function array_of_objects_to_arrays(array $array): array
{
    return array_map(
        fn(Arrayable $child) => $child->toArray(),
        $array
    );
}

/**
 * @param mixed[] $array
 * @param DtoInterface|string $childClass
 * @return DtoInterface[]
 */
function arrays_to_array_of_objects(array $array, string $childClass): array
{
    return array_map(
        fn(array $child) => $childClass::makeFromArray($child),
        $array
    );
}
