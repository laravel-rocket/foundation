<?php

namespace LaravelRocket\Foundation\Helpers\Production;

use Illuminate\Http\UploadedFile;
use LaravelRocket\Foundation\Helpers\FileHelperInterface;

class FileHelper implements FileHelperInterface
{
    public function getFileIconHTML(string $mimeType): string
    {
        if (preg_match('/^([^\/]+)\/([^\/]+)$/', $mimeType, $matches)) {
            switch ($mimeType) {
                case 'application/msword':
                case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                    return '<i class="far fa-file-word"></i>';
                case 'application/vnd.ms-excel':
                case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                    return '<i class="far fa-file-excel"></i>';
                case 'application/vnd.ms-powerpoint':
                case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                    return '<i class="far fa-file-powerpoint"></i>';
                case 'application/pdf':
                    return '<i class="far fa-file-pdf"></i>';
                case 'text/html':
                case 'application/xml':
                    return '<i class="far fa-file-code"></i>';
                case 'application/zip':
                case 'application/x-tar':
                case 'application/x-rar-compressed':
                case 'application/x-bzip':
                case 'application/x-bzip2':
                    return '<i class="far fa-file-archive"></i>';
            }

            switch ($matches[1]) {
                case 'image':
                    return '<i class="far fa-file-image"></i>';
                case 'audio':
                    return '<i class="far fa-file-audio"></i>';
                case 'video':
                    return '<i class="far fa-file-video"></i>';
                case 'text':
                    return '<i class="far fa-file-alt"></i>';
            }
        }

        return '<i class="far fa-file"></i>';
    }

    public function detectFileType(UploadedFile $file): ?string
    {
        $mimeType = $file->getMimeType();

        $types = config('file.acceptable');
        foreach ($types as $name => $candidates) {
            if (array_key_exists($mimeType, $candidates)) {
                return $name;
            }
        }

        return null;
    }
}
