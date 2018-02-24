<?php
namespace LaravelRocket\Foundation\Helpers;

interface ArrayHelperInterface
{
    /**
     * @param string $key
     * @param array  $array
     * @param mixed  $default
     *
     * @return mixed
     */
    public function popWithKey(string $key, array &$array, $default = null);
}
