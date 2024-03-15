<?php
namespace LaravelRocket\Foundation\Helpers;

interface StringHelperInterface
{
    /**
     * @param int $length
     *
     * @return string
     */
    public function randomString(int $length): string;

    /**
     * @param int $length
     *
     * @return string
     */
    public function randomReadableString(int $length): string;

    /**
     * @param string $haystack
     * @param array  $needles
     *
     * @return bool
     */
    public function hasPrefix(string $haystack, array $needles): bool;
}
