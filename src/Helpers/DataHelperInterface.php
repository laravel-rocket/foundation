<?php
namespace LaravelRocket\Foundation\Helpers;

interface DataHelperInterface
{
    /**
     * @param string $countryCode
     * @param string $default
     *
     * @return string
     */
    public function getCountryName(string $countryCode, string $default = ''): string;

    /**
     * @param string $currencyCode
     * @param string $default
     *
     * @return string
     */
    public function getCurrencyName(string $currencyCode, string $default = ''): string;
}
