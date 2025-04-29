<?php

namespace App\Infrastructure\Adapter\Notification;

use App\Domain\Model\Notification;
use App\Domain\ValueObject\NotificationType;
use App\Port\Output\SendNotificationInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailAdapter implements SendNotificationInterface
{
    public function __construct(
        private MailerInterface $mailer
    ) {}

    public function send(Notification $notification): bool
    {
        if ($notification->getType() !== NotificationType::EMAIL) {
            return false;
        }

        try {
            $email = (new Email())
                ->from('noreply@example.com')
                ->to($notification->getRecipient())
                ->subject($notification->getSubject())
                ->html($notification->getContent());

            $this->mailer->send($email);
            
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
} 