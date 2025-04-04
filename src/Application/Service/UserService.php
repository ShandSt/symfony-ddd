<?php

namespace App\Application\Service;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function createUser(string $email, string $name): User
    {
        $existingUser = $this->userRepository->findByEmail($email);
        if ($existingUser) {
            throw new \RuntimeException('User with this email already exists');
        }

        $user = new User($email, $name);
        $this->userRepository->save($user);

        return $user;
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
} 