<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Model\Notification;
use App\Domain\Repository\NotificationRepositoryInterface;
use App\Domain\ValueObject\NotificationType;
use App\Port\Input\CreateNotificationInterface;
use App\Port\Output\SendNotificationInterface;
use App\Domain\Model\User;
use App\Port\Output\NotificationInterface;

class NotificationService implements CreateNotificationInterface
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository,
        private SendNotificationInterface $notificationSender,
        private readonly NotificationInterface $notificationAdapter
    ) {}

    public function create(
        string $recipient,
        string $subject,
        string $content,
        NotificationType $type
    ): Notification {
        $notification = new Notification($recipient, $subject, $content, $type);
        $this->notificationRepository->save($notification);
        
        return $notification;
    }

    public function findById(int $id): ?Notification
    {
        return $this->notificationRepository->findById($id);
    }

    public function send(Notification $notification): bool
    {
        $result = $this->notificationSender->send($notification);
        
        if ($result) {
            $notification->markAsSent();
        } else {
            $notification->markAsFailed();
        }
        
        $this->notificationRepository->save($notification);
        
        return $result;
    }

    public function processQueue(): int
    {
        $pendingNotifications = $this->notificationRepository->findPendingNotifications();
        $processedCount = 0;
        
        foreach ($pendingNotifications as $notification) {
            if ($this->send($notification)) {
                $processedCount++;
            }
        }
        
        return $processedCount;
    }

    public function sendWelcomeNotification(User $user): void
    {
        $recipient = $user->getEmail()->getValue();
        $subject = 'Welcome to our platform!';
        $content = sprintf(
            '<h1>Welcome, %s!</h1><p>Thank you for registering with our platform.</p>',
            htmlspecialchars($user->getName())
        );

        $this->notificationAdapter->send($recipient, $subject, $content);
    }

    public function sendPasswordResetNotification(User $user, string $resetToken): void
    {
        $recipient = $user->getEmail()->getValue();
        $subject = 'Password Reset Request';
        $content = sprintf(
            '<h1>Password Reset</h1><p>Click the link below to reset your password:</p><p><a href="%s">Reset Password</a></p>',
            sprintf('https://example.com/reset-password?token=%s', $resetToken)
        );

        $this->notificationAdapter->send($recipient, $subject, $content);
    }
} 