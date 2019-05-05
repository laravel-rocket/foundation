<?php
namespace LaravelRocket\Foundation\Services\Production;

use Illuminate\Support\Arr;
use LaravelRocket\Foundation\Services\FileUploadLocalServiceInterface;

class FileUploadLocalService extends FileUploadService implements FileUploadLocalServiceInterface
{
    public function upload($srcPath, $mediaType, $filename, $attributes)
    {
        $uploadDirectory = Arr::get($attributes, 'uploadDirectory', config('file.storage.local.path'));
        $baseUrl         = Arr::get($attributes, 'baseUrl', config('file.storage.local.url'));

        $url     = '';
        $success = false;

        if (file_exists($srcPath)) {
            $dstPath = $uploadDirectory.'/'.$filename;
            copy($srcPath, $dstPath);
            $url     = $baseUrl.'/'.$filename;
            $success = true;
        }

        return [
            'success' => $success,
            'url'     => $url,
        ];
    }

    public function delete($attributes)
    {
        $uploadDirectory = Arr::get($attributes, 'uploadDirectory', config('file.storage.local.path'));
        $key             = Arr::get($attributes, 'key');

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
        $buckets = config('file.storage.s3.buckets');

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
                'key'    => Arr::get($config, 'key'),
                'secret' => Arr::get($config, 'secret'),
            ],
            'region'  => $region,
            'version' => 'latest',
        ]);
    }
}
