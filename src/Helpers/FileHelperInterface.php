<?php
namespace LaravelRocket\Foundation\Helpers;

interface FileHelperInterface
{
    /**
     * @param string $mimeType
     *
     * @return string
     */
    public function getFileIconHTML(string $mimeType): string;

    /**
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return string|null
     */
    public function detectFileType(\Illuminate\Http\UploadedFile $file): ?string;
}
