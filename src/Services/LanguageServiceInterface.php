<?php

namespace LaravelRocket\Foundation\Services;

interface LanguageServiceInterface extends BaseServiceInterface
{
    public function normalize(string $language): string;

    public function detect(?string $language = null): string;
}
