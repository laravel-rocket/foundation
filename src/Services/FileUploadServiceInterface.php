<?php

namespace LaravelRocket\Foundation\Services;

interface FileUploadServiceInterface extends BaseServiceInterface
{
    /**
     * @param string $srcPath
     * @param string $mediaType
     * @param string $filename
     * @param array $attributes
     * @return array
     */
    public function upload($srcPath, $mediaType, $filename, $attributes);

    /**
     * @param  array $attributes
     * @return array
     */
    public function delete($attributes);

}
