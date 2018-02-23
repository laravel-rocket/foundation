<?php
namespace LaravelRocket\Foundation\Helpers;

interface FileHelperInterface
{
    /**
     * @param $mimeType
     *
     * @return string
     */
    public function getFileIconHTML($mimeType);
}
