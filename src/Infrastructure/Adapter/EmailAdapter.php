<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapter;

use App\Port\Output\NotificationInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailAdapter implements NotificationInterface
{
    public function __construct(
        private readonly MailerInterface $mailer
    ) {
    }

    public function send(string $recipient, string $subject, string $content): void
    {
        $email = (new Email())
            ->from('no-reply@example.com')
            ->to($recipient)
            ->subject($subject)
            ->html($content);

        $this->mailer->send($email);
    }
} 