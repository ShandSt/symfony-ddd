<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Notification;
use App\Domain\Repository\NotificationRepositoryInterface;
use App\Domain\ValueObject\NotificationStatus;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineNotificationRepository implements NotificationRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        $this->repository = $this->entityManager->getRepository(Notification::class);
    }

    public function save(Notification $notification): void
    {
        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }

    public function findById(int $id): ?Notification
    {
        return $this->repository->find($id);
    }

    public function findByStatus(NotificationStatus $status): array
    {
        return $this->repository->findBy(['status' => $status]);
    }

    public function findPendingNotifications(): array
    {
        return $this->findByStatus(NotificationStatus::PENDING);
    }
} 