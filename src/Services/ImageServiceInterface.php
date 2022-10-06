<?php

namespace LaravelRocket\Foundation\Services;

interface ImageServiceInterface extends BaseServiceInterface
{
    /**
     * @param string $src file path
     * @param string $dst file path
     * @param ?string $format file format
     * @param array $size [ width, height ]
     * @param bool $needExactSize boolean
     * @param string $backgroundColor hex color
     *
     * @return array
     */
    public function convert(string $src, string $dst, ?string $format, array $size, bool $needExactSize = false, string $backgroundColor = '#FFFFFF'): array;

    /**
     * @param string $src
     *
     * @return array
     */
    public function getImageSize(string $src): array;
}
