<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Security\User;

use Ramsey\Uuid\UuidInterface;

final class PurpleCloudsUser implements ECorpIdpUserInterface
{
    private UuidInterface $userUuid;
    private string $email;
    private array $roles;
    private string $rawToken;

    public function __construct(UuidInterface $userUuid, string $email, array $roles, string $rawToken)
    {
        $this->userUuid = $userUuid;
        $this->email = $email;
        $this->roles = $roles;
        $this->rawToken = $rawToken;
    }

    public function getUserUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRawToken(): string
    {
        return $this->rawToken;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }
}