<?php
namespace LaravelRocket\Foundation\Services\Production;

use LaravelRocket\Foundation\Services\FileUploadLocalServiceInterface;

class FileUploadLocalService extends FileUploadService implements FileUploadLocalServiceInterface
{
    public function upload($srcPath, $mediaType, $filename, $attributes)
    {
        $uploadDirectory = array_get($attributes, 'uploadDirectory', config('storage.local.path'));
        $key             = array_get($attributes, 'key');
        $baseUrl         = array_get($attributes, 'baseUrl', config('storage.local.url'));

        $url     = '';
        $success = false;

        if (file_exists($srcPath)) {
            $dstPath = $uploadDirectory.'/'.$key;
            copy($srcPath, $dstPath);
            $url     = $baseUrl.'/'.$key;
            $success = true;
        }

        return [
            'success' => $success,
            'url'     => $url,
        ];
    }

    public function delete($attributes)
    {
        $uploadDirectory = array_get($attributes, 'uploadDirectory', config('storage.local.path'));
        $key             = array_get($attributes, 'key');

        $filePath = $uploadDirectory.'/'.$key;

        $success = false;

        if (!file_exists($filePath)) {
            unlink($filePath);
        }

        return [
            'success' => $success,
        ];
    }

    protected function getDefaultBucket()
    {
        $buckets = config('storage.s3.buckets');

        return $this->decideBucket($buckets);
    }

    protected function decideBucket($buckets, $default = null)
    {
        if (is_array($buckets)) {
            $pos = ord(time() % 10) % count($buckets);

            return $buckets[$pos];
        }

        if (is_string($buckets)) {
            return $buckets;
        }

        return $default;
    }

    /**
     * @param string $region
     *
     * @return S3Client
     */
    protected function getS3Client($region)
    {
        $config = config('aws');

        return new S3Client([
            'credentials' => [
                'key'    => array_get($config, 'key'),
                'secret' => array_get($config, 'secret'),
            ],
            'region'  => $region,
            'version' => 'latest',
        ]);
    }
}
