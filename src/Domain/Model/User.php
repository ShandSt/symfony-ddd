<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;

class User
{
    private ?int $id = null;
    private Email $email;
    private Password $password;
    private string $name;
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct(
        Email $email,
        Password $password,
        string $name
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;
        $this->setUpdatedAt();
        
        return $this;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function setPassword(Password $password): self
    {
        $this->password = $password;
        $this->setUpdatedAt();
        
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        $this->setUpdatedAt();
        
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    private function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function verifyPassword(string $plainPassword): bool
    {
        return $this->password->verify($plainPassword);
    }
} 