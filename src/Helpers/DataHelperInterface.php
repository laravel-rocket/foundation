<?php
namespace LaravelRocket\Foundation\Helpers;

interface DataHelperInterface
{
    /**
     * @param string $countryCode
     * @param string $default
     *
     * @return mixed
     */
    public function getCountryName(string $countryCode, string $default = '');

    /**
     * @param string $currencyCode
     * @param string $default
     *
     * @return mixed
     */
    public function getCurrencyName(string $currencyCode, string $default = '');
}
