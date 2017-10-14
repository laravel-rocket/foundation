<?php
namespace LaravelRocket\Foundation\Http\Requests;

class APIRequest extends Request
{
    /** @var \Restful\Files */
    protected $fileParser = null;

    /** @var \Restful\Parser */
    protected $requestParser = null;

    /**
     * @param string $key     the key
     * @param mixed  $default the default value if the parameter key does not exist
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->needParser()) {
            $this->treatPutRequest();

            $data = array_get($_REQUEST, $key, $default);
        } else {
            $data = parent::get($key, $default);
        }

        // Support Android Retrofit Bad Data Format
        if (starts_with(request()->header('Content-Type'), 'multipart/form-data')) {
            if (starts_with($data, 'Content')) {
                $pos = strpos($data, "\r\n\r\n");
                if ($pos !== false) {
                    $data = substr($data, $pos + 4);
                }
            }
        }

        return $data;
    }

    /**
     * Determine if the request contains a non-empty value for an input item.
     *
     * @param string|array $key
     *
     * @return bool
     */
    public function has($key)
    {
        if ($this->needParser()) {
            $this->treatPutRequest();

            return array_key_exists($key, $_REQUEST);
        }

        return parent::has($key);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasFile($key)
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
     * @param string $key
     * @param mixed  $default
     *
     * @return \Illuminate\Http\UploadedFile|array|null
     */
    public function file($key = null, $default = null)
    {
        if ($this->needParser()) {
            $this->treatPutRequest();
            $fileObjects = [];
            if ($this->hasFile($key)) {
                $files = $this->fileParser->getFiles($key);
                foreach ($files as $key => $file) {
                    $originalName  = array_get($file, 'name');
                    $mimeType      = array_get($file, 'type');
                    $path          = array_get($file, 'tmp_name');
                    $size          = array_get($file, 'size');
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

    /**
     * @return bool
     */
    protected function needParser()
    {
        $methods = ['PUT', 'PATCH'];

        return app()->environment() !== 'testing' && in_array($_SERVER['REQUEST_METHOD'], $methods);
    }

    protected function treatPutRequest()
    {
        if (empty($this->requestParser)) {
            $this->requestParser = new \Restful\Parser();
            $this->requestParser->parse();

            $this->fileParser = new \Restful\Files();
            $this->fileParser->parse();
        }
    }
}
