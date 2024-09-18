<?php

namespace LaravelRocket\Foundation\Helpers;

interface URLHelperInterface
{
    public function swapHost(string $url, string $host): string;

    public function canonicalizeHost(string $url, ?string $locale = null): string;

    public function normalizeUrlPath(string $urlPath): string;

    public function getHostWithLocale(?string $locale = null, ?string $host = null): string;

    public function asset(string $path, string $type = 'user'): string;

    public function elixir(string $path, string $type = 'user'): string;
}
