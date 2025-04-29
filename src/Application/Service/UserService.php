<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Model\User;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Port\Input\UserServiceInterface;
use App\Port\Output\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly NotificationService $notificationService
    ) {
    }

    public function registerUser(string $email, string $password, string $name): User
    {
        // Check if user already exists
        $existingUser = $this->userRepository->findByEmail($email);
        if ($existingUser !== null) {
            throw new \InvalidArgumentException('User with this email already exists');
        }

        // Create new user
        $user = new User(
            new Email($email),
            new Password($password),
            $name
        );

        // Save user
        $this->userRepository->save($user);
        
        // Send welcome notification
        $this->notificationService->sendWelcomeNotification($user);

        return $user;
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    public function authenticateUser(string $email, string $password): ?User
    {
        $user = $this->userRepository->findByEmail($email);
        
        if ($user === null || !$user->verifyPassword($password)) {
            return null;
        }
        
        return $user;
    }

    public function updateUserProfile(int $userId, array $data): User
    {
        $user = $this->userRepository->findById($userId);
        
        if ($user === null) {
            throw new \InvalidArgumentException('User not found');
        }
        
        if (isset($data['name'])) {
            $user->setName($data['name']);
        }
        
        if (isset($data['email'])) {
            $user->setEmail(new Email($data['email']));
        }
        
        if (isset($data['password'])) {
            $user->setPassword(new Password($data['password']));
        }
        
        $this->userRepository->save($user);
        
        return $user;
    }
} 