<?php

namespace LaravelRocket\Foundation\Helpers;

interface StringHelperInterface
{
    public function randomString(int $length): string;

    public function randomReadableString(int $length): string;

    public function hasPrefix(string $haystack, array $needles): bool;
}
