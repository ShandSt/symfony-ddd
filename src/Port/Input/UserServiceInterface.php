<?php

declare(strict_types=1);

namespace App\Port\Input;

use App\Domain\Model\User;

interface UserServiceInterface
{
    /**
     * Register a new user in the system
     */
    public function registerUser(string $email, string $password, string $name): User;
    
    /**
     * Find user by email
     */
    public function findUserByEmail(string $email): ?User;
    
    /**
     * Authenticate user by credentials
     */
    public function authenticateUser(string $email, string $password): ?User;
    
    /**
     * Update user profile
     */
    public function updateUserProfile(int $userId, array $data): User;
} 