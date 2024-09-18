<?php

namespace LaravelRocket\Foundation\Services\Production;

use LaravelRocket\Foundation\Services\FileUploadServiceInterface;

class FileUploadService extends BaseService implements FileUploadServiceInterface
{
    public function upload(string $srcPath, string $mediaType, string $filename, array $attributes): array
    {
        return [
            'success' => false,
        ];
    }

    public function delete(array $attributes): array
    {
        return [
            'success' => false,
        ];
    }
}
