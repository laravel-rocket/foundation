<?php
namespace LaravelRocket\Foundation\Helpers;

interface ArrayHelperInterface
{
    /**
     * @param string $key
     * @param array  $array
     * @param mixed|null $default
     */
    public function popWithKey(string $key, array &$array, mixed $default = null);

    /**
     * @param array $array
     * @param array $keys
     * @param bool  $removeEmptyElements
     *
     * @return array
     */
    public function filterElements(array $array, array $keys, bool $removeEmptyElements = true): array;
}
