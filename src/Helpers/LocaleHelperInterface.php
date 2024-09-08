<?php

namespace LaravelRocket\Foundation\Helpers;

interface LocaleHelperInterface
{
    /**
     * Set Locale.
     */
    public function setLocale(?string $locale = null, ?\LaravelRocket\Foundation\Models\Traits\LocaleStorable $user = null): string;

    public function getLocale(): string;

    public function getLocaleSubDomain(): string;

    public function getEnableLocales(): array;

    public function getLocalesForForm(): array;
}
