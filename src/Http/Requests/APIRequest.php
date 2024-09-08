<?php

namespace LaravelRocket\Foundation\Http\Requests;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class APIRequest extends Request
{
    protected ?\Restful\Files $fileParser = null;

    protected ?\Restful\Parser $requestParser = null;

    /**
     * @param  string  $key  the key
     * @param  mixed|null  $default  the default value if the parameter key does not exist
     */
    public function get(string $key, mixed $default = null): mixed
    {
        if ($this->needParser()) {
            $data = parent::get($key);
            if (empty($data)) {
                $this->treatPutRequest();
                $data = Arr::get($_REQUEST, $key, $default);
            }
        } else {
            $data = parent::get($key, $default);
        }

        // Support Android Retrofit Bad Data Format
        if (Str::startsWith(request()->header('Content-Type'), 'multipart/form-data')) {
            if (is_array($data)) {
                $newData = [];
                foreach ($data as $value) {
                    if (Str::startsWith($value, 'Content')) {
                        $pos = strpos($value, "\r\n\r\n");
                        if ($pos !== false) {
                            $value = substr($value, $pos + 4);
                        }
                    }
                    $newData[] = $value;
                }
                $data = $newData;
            } else {
                if (Str::startsWith($data, 'Content')) {
                    $pos = strpos($data, "\r\n\r\n");
                    if ($pos !== false) {
                        $data = substr($data, $pos + 4);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Determine if the request contains a non-empty value for an input item.
     *
     * @param  string|array  $key
     */
    public function has($key): bool
    {
        if ($this->needParser()) {
            $this->treatPutRequest();

            return array_key_exists($key, $_REQUEST);
        }

        return parent::has($key);
    }

    /**
     * @param  string  $key
     */
    public function hasFile($key): bool
    {
        if ($this->needParser()) {
            $this->treatPutRequest();
            $files = $this->fileParser->getParsed();

            return array_key_exists($key, $files);
        }

        return parent::hasFile($key);
    }

    /**
     * Retrieve a file from the request.
     *
     * @param  string  $key
     * @param  mixed  $default
     */
    public function file($key = null, $default = null): array|\Illuminate\Http\UploadedFile|null
    {
        if ($this->needParser()) {
            $this->treatPutRequest();
            $fileObjects = [];
            if ($this->hasFile($key)) {
                $files = $this->fileParser->getFiles($key);
                foreach ($files as $key => $file) {
                    $originalName = Arr::get($file, 'name');
                    $mimeType = Arr::get($file, 'type');
                    $path = Arr::get($file, 'tmp_name');
                    $size = Arr::get($file, 'size');
                    $fileObjects[] = new \Illuminate\Http\UploadedFile($path, $originalName, $mimeType, $size);
                }
            }
            if (count($fileObjects) == 0) {
                return $default;
            } elseif (count($fileObjects) == 1) {
                return $fileObjects[0];
            }

            return $fileObjects;
        }

        return parent::file($key, $default);
    }

    protected function needParser(): bool
    {
        $methods = ['PUT', 'PATCH'];

        return app()->environment() !== 'testing' && in_array($_SERVER['REQUEST_METHOD'], $methods);
    }

    protected function treatPutRequest(): void
    {
        if (empty($this->requestParser)) {
            $this->requestParser = new \Restful\Parser;
            $this->requestParser->parse();

            $this->fileParser = new \Restful\Files;
            $this->fileParser->parse();
        }
    }
}
