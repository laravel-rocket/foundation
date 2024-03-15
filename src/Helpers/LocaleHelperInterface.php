<?php
namespace LaravelRocket\Foundation\Helpers;

interface LocaleHelperInterface
{
    /**
     * Set Locale.
     *
     * @param string|null $locale
     * @param \LaravelRocket\Foundation\Models\Traits\LocaleStorable|null $user
     *
     * @return string
     */
    public function setLocale(string $locale = null, \LaravelRocket\Foundation\Models\Traits\LocaleStorable $user = null): string;

    /**
     * @return string
     */
    public function getLocale(): string;

    /**
     * @return string
     */
    public function getLocaleSubDomain(): string;

    /**
     * @return array
     */
    public function getEnableLocales(): array;

    /**
     * @return array
     */
    public function getLocalesForForm(): array;
}
