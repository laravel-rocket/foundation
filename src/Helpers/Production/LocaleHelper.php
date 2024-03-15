<?php
namespace LaravelRocket\Foundation\Helpers\Production;

use Illuminate\Support\Arr;
use LaravelRocket\Foundation\Helpers\LocaleHelperInterface;
use LaravelRocket\Foundation\Models\Traits\LocaleStorable;

class LocaleHelper implements LocaleHelperInterface
{
    public function getLocale(): string
    {
        $pieces           = explode('.', request()->getHost());
        $locale           = null;
        $availableDomains = config('locale.domains', []);

        if (in_array(strtolower($pieces[0]), $availableDomains)) {
            $locale = strtolower($pieces[0]);
        }

        if (empty($locale)) {
            $locale = $this->setLocale();
        }

        if (request()->has('fb_locale')) {
            $fbLocale  = request()->get('fb_locale');
            $languages = array_filter(config('locale.languages'), function($language) use ($fbLocale) {
                if (Arr::get($language, 'ogp') === $fbLocale) {
                    return true;
                }

                return false;
            });

            if ($languages) {
                reset($languages);
                $locale = key($languages);
            }
        }

        return $locale;
    }

    public function setLocale(string $locale = null, LocaleStorable $user = null): string
    {
        if (isset($locale)) {
            $locale = strtolower($locale);
            if (array_key_exists($locale, config('locale.languages'))) {
                if (!empty($user)) {
                    $user->setLocale($locale);
                }
                session()->put('locale', $locale);
            } else {
                $locale = null;
            }
        }

        if (empty($locale)) {
            if (!empty($user)) {
                $locale = $user->getLocale();
            }
            if (empty($locale)) {
                $locale = session()->get('locale');
            }
        }
        if (empty($locale)) {
            $locale = $this->parseAcceptLanguage();
        }

        return $locale;
    }

    private function parseAcceptLanguage()
    {
        $languages = [];
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            preg_match_all(
                '/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i',
                $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                $lang_parse
            );
            if (count($lang_parse[1])) {
                $languages = array_combine($lang_parse[1], $lang_parse[4]);
                foreach ($languages as $lang => $val) {
                    if ($val === '') {
                        $languages[$lang] = 1;
                    }
                }
            }
        }
        foreach ($languages as $lang => $val) {
            foreach (config('locale.languages') as $langCode => $data) {
                if (str_starts_with(strtolower($lang), $langCode)) {
                    return $langCode;
                }
            }
        }

        return config('locale.default');
    }

    public function getLocaleSubDomain(): string
    {
        $pieces           = explode('.', request()->getHost());
        $locale           = null;
        $availableDomains = config('locale.domains', []);

        if (in_array(strtolower($pieces[0]), $availableDomains)) {
            $locale = strtolower($pieces[0]);
        }

        return $locale;
    }

    public function getEnableLocales(): array
    {
        return Arr::where(config('locale.languages'), function($value, $key) {
            return $value['status'] == true;
        });
    }

    /**
     * @return array
     */
    public function getLocalesForForm(): array
    {
        $locales = [];
        foreach (self::getEnableLocales() as $k => $locale) {
            Arr::get($locales, $k, trans(Arr::get($locale, 'name')));
        }

        return $locales;
    }
}
