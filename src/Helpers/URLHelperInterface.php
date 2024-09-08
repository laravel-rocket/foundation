<?php
namespace LaravelRocket\Foundation\Helpers;

interface URLHelperInterface
{
    /**
     * @param string $url
     * @param string $host
     *
     * @return string
     */
    public function swapHost(string $url, string $host): string;

    /**
     * @param string $url
     * @param string|null $locale
     *
     * @return string
     */
    public function canonicalizeHost(string $url, string $locale = null): string;

    /**
     * @param string $urlPath
     *
     * @return string
     */
    public function normalizeUrlPath(string $urlPath): string;

    /**
     * @param string|null $locale
     * @param string|null $host
     *
     * @return string
     */
    public function getHostWithLocale(string $locale = null, string $host = null): string;

    /**
     * @param string $path
     * @param string $type
     *
     * @return string
     */
    public function asset(string $path, string $type = 'user'): string;

    /**
     * @param string $path
     * @param string $type
     *
     * @return string
     */
    public function elixir(string $path, string $type = 'user'): string;
}
