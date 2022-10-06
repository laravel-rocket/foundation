<?php
namespace LaravelRocket\Foundation\Services;

interface SlackServiceInterface extends BaseServiceInterface
{
    /**
     * Report an exception to slack.
     *
     * @param \Exception $e
     */
    public function exception(\Exception $e);

    /**
     * @param string $message
     * @param string $type
     * @param array $attachment
     */
    public function post(string $message, string $type, array $attachment = []);
}
