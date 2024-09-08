<?php

namespace LaravelRocket\Foundation\Helpers;

interface ArrayHelperInterface
{
    public function popWithKey(string $key, array &$array, mixed $default = null): mixed;

    public function filterElements(array $array, array $keys, bool $removeEmptyElements = true): array;
}
