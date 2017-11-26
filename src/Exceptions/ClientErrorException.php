<?php
namespace LaravelRocket\Foundation\Exceptions;

use Exception;

class ClientErrorException extends Exception
{
    public function __construct($error, $message = '', $userMessage = '')
    {
        parent::__construct($message);
    }
}
