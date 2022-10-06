<?php
namespace LaravelRocket\Foundation\Services;

interface LanguageServiceInterface extends BaseServiceInterface
{
    /**
     * @param string $language
     *
     * @return string
     */
    public function normalize(string $language): string;

    /**
     * @param ?string $language
     *
     * @return string
     */
    public function detect(string $language = null): string;
}
