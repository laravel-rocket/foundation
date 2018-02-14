<?php
namespace LaravelRocket\Foundation\Helpers;

interface CountryHelperInterface
{
    /**
     * @param string $countryCode
     * @param string $default
     *
     * @return mixed
     */
    public function getCountryName(string $countryCode, string $default = '');
}
