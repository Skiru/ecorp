<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Security\User;

use Ramsey\Uuid\UuidInterface;

class SecurityUser implements ECorpIdpUserInterface
{
    private UuidInterface $uuid;
    private int $id;
    private string $email;
    private array $roles;
    private string $passwordHash;

    public function __construct(UuidInterface $uuid, int $id, string $email, array $roles, string $passwordHash)
    {
        $this->uuid = $uuid;
        $this->id = $id;
        $this->email = $email;
        $this->roles = $roles;
        $this->passwordHash = $passwordHash;
    }

    public function getUserUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->passwordHash;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        return null;
    }
}