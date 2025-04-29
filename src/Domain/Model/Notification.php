<?php

namespace App\Domain\Model;

use App\Domain\ValueObject\NotificationType;
use App\Domain\ValueObject\NotificationStatus;
use DateTimeImmutable;

class Notification
{
    private ?int $id = null;
    private string $recipient;
    private string $subject;
    private string $content;
    private NotificationType $type;
    private NotificationStatus $status;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $sentAt = null;

    public function __construct(
        string $recipient,
        string $subject,
        string $content,
        NotificationType $type
    ) {
        $this->recipient = $recipient;
        $this->subject = $subject;
        $this->content = $content;
        $this->type = $type;
        $this->status = NotificationStatus::PENDING;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getType(): NotificationType
    {
        return $this->type;
    }

    public function getStatus(): NotificationStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getSentAt(): ?DateTimeImmutable
    {
        return $this->sentAt;
    }

    public function markAsSent(): void
    {
        $this->status = NotificationStatus::SENT;
        $this->sentAt = new DateTimeImmutable();
    }

    public function markAsFailed(): void
    {
        $this->status = NotificationStatus::FAILED;
    }
} 