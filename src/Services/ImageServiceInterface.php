<?php
namespace LaravelRocket\Foundation\Services;

interface ImageServiceInterface extends BaseServiceInterface
{
    /**
     * @param string      $src             file path
     * @param string      $dst             file path
     * @param string|null $format          file format
     * @param array       $size            [ width, height ]
     * @param bool        $needExactSize   boolean
     * @param string      $backgroundColor hex color
     *
     * @return array
     */
    public function convert($src, $dst, $format, $size, $needExactSize = false, $backgroundColor = '#FFFFFF');
}
