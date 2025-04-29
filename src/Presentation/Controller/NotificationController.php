<?php

namespace App\Presentation\Controller;

use App\Application\Service\NotificationService;
use App\Domain\ValueObject\NotificationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/notifications')]
class NotificationController extends AbstractController
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        try {
            $type = NotificationType::from($data['type'] ?? 'email');
            
            $notification = $this->notificationService->create(
                $data['recipient'] ?? '',
                $data['subject'] ?? '',
                $data['content'] ?? '',
                $type
            );

            return $this->json([
                'id' => $notification->getId(),
                'recipient' => $notification->getRecipient(),
                'subject' => $notification->getSubject(),
                'type' => $notification->getType()->value,
                'status' => $notification->getStatus()->value
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/{id}/send', methods: ['POST'])]
    public function send(int $id): JsonResponse
    {
        $notification = $this->notificationService->findById($id);

        if (!$notification) {
            return $this->json(['error' => 'Notification not found'], Response::HTTP_NOT_FOUND);
        }

        $result = $this->notificationService->send($notification);

        return $this->json([
            'success' => $result,
            'status' => $notification->getStatus()->value
        ]);
    }

    #[Route('/process-queue', methods: ['POST'])]
    public function processQueue(): JsonResponse
    {
        $count = $this->notificationService->processQueue();

        return $this->json([
            'processed' => $count
        ]);
    }
} 