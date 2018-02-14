<?php
namespace LaravelRocket\Foundation\Helpers\Production;

use LaravelRocket\Foundation\Helpers\CountryHelperInterface;

class CountryHelper implements CountryHelperInterface
{
    public function getCountryName(string $countryCode, string $default = '')
    {
        $countryCode = strtoupper($countryCode);
        $length      = strlen($countryCode);
        if ($length !== 2 && $length !== 3) {
            return $default;
        }

        $key = config('data/data/countries.country_codes.'.$length.'digits.', $countryCode);
        if (empty($key)) {
            return $default;
        }

        return trans('data/countries.'.$key);
    }
}
