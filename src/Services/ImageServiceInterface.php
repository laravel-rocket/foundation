<?php

namespace LaravelRocket\Foundation\Services;

interface ImageServiceInterface extends BaseServiceInterface
{
    /**
     * @param  string  $src  file path
     * @param  string  $dst  file path
     * @param  ?string  $format  file format
     * @param  array  $size  [ width, height ]
     * @param  bool  $needExactSize  boolean
     * @param  string  $backgroundColor  hex color
     */
    public function convert(string $src, string $dst, ?string $format, array $size, bool $needExactSize = false, string $backgroundColor = '#FFFFFF'): array;

    public function getImageSize(string $src): array;
}
