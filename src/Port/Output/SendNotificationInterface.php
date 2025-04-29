<?php

namespace App\Port\Output;

use App\Domain\Model\Notification;

interface SendNotificationInterface
{
    public function send(Notification $notification): bool;
} 