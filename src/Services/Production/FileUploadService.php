<?php

namespace LaravelRocket\Foundation\Services\Production;

use LaravelRocket\Foundation\Services\FileUploadServiceInterface;

class FileUploadService extends BaseService implements FileUploadServiceInterface
{
    public function upload($srcPath, $mediaType, $filename, $attributes)
    {
        return [
            'success' => false,
        ];
    }

    public function delete($attributes)
    {
        return [
            'success' => false,
        ];
    }

}
