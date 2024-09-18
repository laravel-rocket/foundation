<?php

namespace LaravelRocket\Foundation\Services\Production;

use Illuminate\Support\Arr;
use LaravelRocket\Foundation\Services\MailServiceInterface;

class MailService extends BaseService implements MailServiceInterface
{
    public function sendMail(string $title, ?array $from, array $to, string $template, array $data): bool
    {
        if (config('app.offline_mode')) {
            return true;
        }

        if (app()->environment() == 'testing') {
            return true;
        }

        if (! in_array(app()->environment(), config('mail.production_environments', ['production']))) {
            $title = '['.app()->environment().'] '.$title;
            $to = [
                'address' => config('mail.tester'),
                'name' => app()->environment().' Original: '.$to['address'],
            ];
        }

        if (! is_array($from) || empty(Arr::get($from, 'address'))) {
            $from = $this->getDefaultSender();
        }

        try {
            \Mail::send($template, $data, function ($m) use ($from, $to, $title) {
                $m->from($from['address'], $from['name']);

                $m->to($to['address'], $to['name'])->subject($title);
            });
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }

        return true;
    }

    public function getDefaultSender(): array
    {
        return config('mail.from', []);
    }
}
