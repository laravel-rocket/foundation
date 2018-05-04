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

    /**
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return string|null
     */
    public function detectFileType($file);
}
