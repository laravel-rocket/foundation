<?php

namespace LaravelRocket\Foundation\Helpers\Production;

use LaravelRocket\Foundation\Helpers\DataHelperInterface;

class DataHelper implements DataHelperInterface
{
    public function getCountryName(string $countryCode, string $default = ''): string
    {
        $countryCode = strtoupper($countryCode);
        $length = strlen($countryCode);
        if ($length !== 2 && $length !== 3) {
            return $default;
        }

        $key = config('data.data.countries.country_codes.'.$length.'digits.'.$countryCode);
        if (empty($key)) {
            return $default;
        }

        return trans('data/countries.'.$key);
    }

    public function getCurrencyName(string $currencyCode, string $default = ''): string
    {
        $currencyCode = strtoupper($currencyCode);
        $length = strlen($currencyCode);
        if ($length !== 3) {
            return $default;
        }

        $key = config('data.data.countries.currency_codes.'.$currencyCode);
        if (empty($key)) {
            return $default;
        }

        return trans('data/currencies.'.$key);
    }
}
