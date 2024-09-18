<?php

namespace LaravelRocket\Foundation\Services;

interface MailServiceInterface extends BaseServiceInterface
{
    public function sendMail(string $title, ?array $from, array $to, string $template, array $data): bool;

    public function getDefaultSender(): array;
}
