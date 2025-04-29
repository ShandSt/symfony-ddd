<?php

declare(strict_types=1);

namespace App\Port\Output;

interface NotificationInterface
{
    /**
     * Send a notification with the given subject and content
     */
    public function send(string $recipient, string $subject, string $content): void;
} 