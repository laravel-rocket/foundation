<?php

namespace LaravelRocket\Foundation\Helpers;

interface DataHelperInterface
{
    public function getCountryName(string $countryCode, string $default = ''): string;

    public function getCurrencyName(string $currencyCode, string $default = ''): string;
}
