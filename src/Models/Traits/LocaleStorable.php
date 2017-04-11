<?php
namespace LaravelRocket\Foundation\Models\Traits;

/**
 * LaravelRocket\Foundation\Models\LocaleStorableTraits.
 *
 * @property string $locale
 *
 * @method static \Illuminate\Database\Query\Builder|\LaravelRocket\Foundation\Models\Traits\LocaleStorable whereLocale($value)
 */
trait LocaleStorable
{
    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = strtolower($locale);
        $this->save();
    }
}
