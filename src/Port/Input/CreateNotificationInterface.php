<?php

namespace App\Port\Input;

use App\Domain\Model\Notification;
use App\Domain\ValueObject\NotificationType;

interface CreateNotificationInterface
{
    public function create(
        string $recipient,
        string $subject,
        string $content,
        NotificationType $type
    ): Notification;
} 