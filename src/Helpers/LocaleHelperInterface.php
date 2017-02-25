<?php

namespace LaravelRocket\Foundation\Helpers;

interface LocaleHelperInterface
{
    /**
     * Set Locale.
     *
     * @param string                                                      $locale
     * @param \LaravelRocket\Foundation\Models\Traits\LocaleStorable|null $user
     *
     * @return string
     */
    public function setLocale($locale = null, $user = null);

    /**
     * @return mixed
     */
    public function getLocale();

    /**
     * @return mixed
     */
    public function getLocaleSubDomain();

    /**
     * @return array
     */
    public function getEnableLocales();
}
