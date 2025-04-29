<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Model\User;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Infrastructure\Persistence\Doctrine\Entity\UserEntity;
use App\Port\Output\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function save(User $user): void
    {
        $userEntity = $this->findUserEntity($user->getId());
        
        if ($userEntity === null) {
            $userEntity = new UserEntity();
        }
        
        $userEntity->setEmail($user->getEmail()->getValue());
        $userEntity->setPassword($user->getPassword()->getHashedValue());
        $userEntity->setName($user->getName());
        
        $this->entityManager->persist($userEntity);
        $this->entityManager->flush();
    }

    public function findById(int $id): ?User
    {
        $userEntity = $this->entityManager->getRepository(UserEntity::class)->find($id);
        
        if ($userEntity === null) {
            return null;
        }
        
        return $this->mapEntityToDomain($userEntity);
    }

    public function findByEmail(string $email): ?User
    {
        $userEntity = $this->entityManager->getRepository(UserEntity::class)
            ->findOneBy(['email' => $email]);
        
        if ($userEntity === null) {
            return null;
        }
        
        return $this->mapEntityToDomain($userEntity);
    }

    public function delete(User $user): void
    {
        $userEntity = $this->findUserEntity($user->getId());
        
        if ($userEntity !== null) {
            $this->entityManager->remove($userEntity);
            $this->entityManager->flush();
        }
    }

    public function findAll(): array
    {
        $userEntities = $this->entityManager->getRepository(UserEntity::class)->findAll();
        
        $users = [];
        foreach ($userEntities as $userEntity) {
            $users[] = $this->mapEntityToDomain($userEntity);
        }
        
        return $users;
    }

    private function findUserEntity(?int $id): ?UserEntity
    {
        if ($id === null) {
            return null;
        }
        
        return $this->entityManager->getRepository(UserEntity::class)->find($id);
    }

    private function mapEntityToDomain(UserEntity $userEntity): User
    {
        $email = new Email($userEntity->getEmail());
        $password = new Password($userEntity->getPassword(), true);
        
        $user = new User($email, $password, $userEntity->getName());
        
        // Set ID using reflection to preserve encapsulation
        $reflectionProperty = new \ReflectionProperty(User::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($user, $userEntity->getId());
        
        return $user;
    }
} 