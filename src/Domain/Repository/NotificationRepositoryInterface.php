<?php

namespace App\Domain\Repository;

use App\Domain\Model\Notification;
use App\Domain\ValueObject\NotificationStatus;

interface NotificationRepositoryInterface
{
    public function save(Notification $notification): void;
    public function findById(int $id): ?Notification;
    public function findByStatus(NotificationStatus $status): array;
    public function findPendingNotifications(): array;
} 