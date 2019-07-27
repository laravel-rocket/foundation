<?php
namespace LaravelRocket\Foundation\Helpers;

interface StringHelperInterface
{
    /**
     * @param int $length
     *
     * @return string
     */
    public function randomString($length);

    /**
     * @param int $length
     *
     * @return string
     */
    public function randomReadableString($length);

    /**
     * @param string $haystack
     * @param array  $needles
     *
     * @return bool
     */
    public function hasPrefix(string $haystack, array $needles);
}
