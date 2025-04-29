<?php

declare(strict_types=1);

namespace App\Port\Output;

use App\Domain\Model\User;

interface UserRepositoryInterface
{
    /**
     * Save a user to the repository
     */
    public function save(User $user): void;
    
    /**
     * Find a user by its ID
     */
    public function findById(int $id): ?User;
    
    /**
     * Find a user by its email
     */
    public function findByEmail(string $email): ?User;
    
    /**
     * Delete a user from the repository
     */
    public function delete(User $user): void;
    
    /**
     * Find all users
     * 
     * @return User[]
     */
    public function findAll(): array;
} 