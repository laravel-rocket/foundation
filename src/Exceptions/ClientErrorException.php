<?php
namespace LaravelRocket\Foundation\Exceptions;

use Exception;

class ClientErrorException extends Exception
{
    /** @var string */
    protected string $errorName = '';

    protected array $extraData = [];

    protected array $config = [];

    /**
     * APIErrorException constructor.
     *
     * @param string $error
     * @param string $message
     * @param array  $extraData
     */
    public function __construct($error, $message = '', $extraData = [])
    {
        $message = !empty($message) ? $message : $error;

        $this->errorName = $error;
        $this->extraData = $extraData;
        parent::__construct($message);
    }

    public function getError()
    {
        return $this->errorName;
    }

    public function getExtraData()
    {
        return $this->extraData;
    }
}
