<?php

namespace LaravelRocket\Foundation\Models\Traits;

/**
 * LaravelRocket\Foundation\Models\LocaleStorable.
 *
 * @property string $locale
 *
 * @method static \Illuminate\Database\Query\Builder|\LaravelRocket\Foundation\Models\Traits\LocaleStorable whereLocale($value)
 */
trait LocaleStorable
{
    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale($locale): void
    {
        $this->locale = strtolower($locale);
        $this->save();
    }
}
