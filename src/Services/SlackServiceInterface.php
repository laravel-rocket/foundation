<?php

namespace LaravelRocket\Foundation\Services;

interface SlackServiceInterface extends BaseServiceInterface
{
    /**
     * Report an exception to slack.
     */
    public function exception(\Exception $e);

    public function post(string $message, string $type, array $attachment = []);
}
