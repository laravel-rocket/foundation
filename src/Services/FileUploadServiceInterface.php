<?php

namespace LaravelRocket\Foundation\Services;

interface FileUploadServiceInterface extends BaseServiceInterface
{
    public function upload(string $srcPath, string $mediaType, string $filename, array $attributes): array;

    public function delete(array $attributes): array;
}
