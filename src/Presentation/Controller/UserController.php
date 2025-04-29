<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Port\Input\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/users')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {
    }

    #[Route('', name: 'register_user', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $user = $this->userService->registerUser(
                $data['email'] ?? '',
                $data['password'] ?? '',
                $data['name'] ?? ''
            );

            return $this->json([
                'id' => $user->getId(),
                'email' => $user->getEmail()->getValue(),
                'name' => $user->getName()
            ], Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return $this->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'An error occurred during registration'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/authenticate', name: 'authenticate_user', methods: ['POST'])]
    public function authenticate(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->userService->authenticateUser(
            $data['email'] ?? '',
            $data['password'] ?? ''
        );

        if ($user === null) {
            return $this->json([
                'error' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail()->getValue(),
            'name' => $user->getName()
        ]);
    }

    #[Route('/{id}', name: 'update_user_profile', methods: ['PUT'])]
    public function updateProfile(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $user = $this->userService->updateUserProfile($id, $data);

            return $this->json([
                'id' => $user->getId(),
                'email' => $user->getEmail()->getValue(),
                'name' => $user->getName()
            ]);
        } catch (\InvalidArgumentException $e) {
            return $this->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'An error occurred while updating profile'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
} 