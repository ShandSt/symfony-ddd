<?php

namespace App\Tests\Domain\Entity;

use App\Domain\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCreation(): void
    {
        $email = 'test@example.com';
        $name = 'Test User';

        $user = new User($email, $name);

        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($name, $user->getName());
        $this->assertNull($user->getId());
    }

    public function testUserEmailUpdate(): void
    {
        $user = new User('test@example.com', 'Test User');
        $newEmail = 'new@example.com';

        $user->setEmail($newEmail);

        $this->assertEquals($newEmail, $user->getEmail());
    }

    public function testUserNameUpdate(): void
    {
        $user = new User('test@example.com', 'Test User');
        $newName = 'New Name';

        $user->setName($newName);

        $this->assertEquals($newName, $user->getName());
    }
} 