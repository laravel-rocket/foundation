<?php
namespace LaravelRocket\Foundation\Services;

interface FileUploadServiceInterface extends BaseServiceInterface
{
    /**
     * @param string $srcPath
     * @param string $mediaType
     * @param string $filename
     * @param array $attributes
     *
     * @return array
     */
    public function upload(string $srcPath, string $mediaType, string $filename, array $attributes): array;

    /**
     * @param array $attributes
     *
     * @return array
     */
    public function delete(array $attributes): array;
}
