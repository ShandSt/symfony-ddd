<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

final class Password
{
    private string $hashedValue;

    public function __construct(string $plainPassword, bool $isHashed = false)
    {
        if (!$isHashed) {
            if (strlen($plainPassword) < 8) {
                throw new InvalidArgumentException('Password must be at least 8 characters long');
            }
            
            $this->hashedValue = password_hash($plainPassword, PASSWORD_ARGON2ID);
        } else {
            $this->hashedValue = $plainPassword;
        }
    }

    public function getHashedValue(): string
    {
        return $this->hashedValue;
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedValue);
    }
} 