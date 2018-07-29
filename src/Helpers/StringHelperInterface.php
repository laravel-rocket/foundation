<?php
namespace LaravelRocket\Foundation\Helpers;

interface StringHelperInterface
{
    /**
     * @param int $length
     *
     * @return string
     */
    public function randomString($length);

    /**
     * @param int $length
     *
     * @return string
     */
    public function randomReadableString($length);
}
