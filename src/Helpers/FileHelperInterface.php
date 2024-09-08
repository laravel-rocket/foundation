<?php

namespace LaravelRocket\Foundation\Helpers;

interface FileHelperInterface
{
    public function getFileIconHTML(string $mimeType): string;

    public function detectFileType(\Illuminate\Http\UploadedFile $file): ?string;
}
