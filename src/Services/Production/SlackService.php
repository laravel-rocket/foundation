<?php

namespace LaravelRocket\Foundation\Services\Production;

use Illuminate\Support\Arr;
use JoliCode\Slack\ClientFactory;
use LaravelRocket\Foundation\Services\SlackServiceInterface;

class SlackService extends BaseService implements SlackServiceInterface
{
    /**
     * Report an exception to slack.
     */
    public function exception(\Exception $e)
    {
        $fields = [];

        $addToField = function ($name, $value, $short = false) use (&$fields) {
            if (! empty($value)) {
                $fields[] = [
                    'title' => $name,
                    'value' => $value,
                    'short' => $short,
                ];
            }
        };

        $addToField('Environment', app()->environment(), true);
        $addToField('Exception', get_class($e), true);
        $addToField(
            'Http code',
            $e instanceof \Symfony\Component\HttpKernel\Exception\HttpException ? $e->getStatusCode() : 500,
            true
        );
        $addToField('Code', $e->getCode(), true);
        $addToField('File', $e->getFile(), true);
        $addToField('Line', $e->getLine(), true);
        $addToField('Request url', request()->url(), true);
        $addToField('Request method', request()->method(), true);
        $addToField('Request param', json_encode(request()->all()), true);

        $message = ':bug: Error Occurs on '.app()->environment();
        $type = 'serious-alert';
        $pretext = 'Error Occurs on '.app()->environment();
        $attachment = [
            'color' => 'danger',
            'title' => $e->getMessage(),
            'fallback' => ! empty($e->getMessage()) ? $e->getMessage() : get_class($e),
            'pretext' => $pretext,
            'fields' => $fields,
            'text' => $e->getTraceAsString(),
        ];

        // notify to slack
        $this->post($message, $type, $attachment);
    }

    public function post(string $message, string $type, array $attachment = [])
    {
        $type = config('slack.types.'.strtolower($type), config('slack.default', []));
        $apiToken = config('slack.apiToken');
        if (empty($webHookUrl)) {
            return;
        }
        $client = ClientFactory::create($apiToken);
        $messageObject = [
            'username' => Arr::get($type, 'username', 'Alert Bot'),
            'channel' => Arr::get($type, 'channel', '#random'),
            'text' => $message,
            'link_names' => true,
            'icon' => Arr::get($type, 'icon', ':smile:'),
        ];
        if (! empty($attachment)) {
            $attachments = [
                [
                    'title' => Arr::get($attachment, 'title', ''),
                    'fallback' => Arr::get($attachment, 'fallback', ''),
                    'text' => Arr::get($attachment, 'text', ''),
                    'pretext' => Arr::get($attachment, 'pretext', ''),
                    'color' => Arr::get($attachment, 'color', 'good'),
                    'fields' => Arr::get($attachment, 'fields', []),
                ],
            ];
            $messageObject['attachments'] = $attachments;
        }
        $client->chatPostMessage($messageObject);
    }
}
