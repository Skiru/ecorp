<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Security\User;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class PurpleCloudsUser implements ECorpUserIdentityInterface
{
    private int $internalId;
    private UuidInterface $userUuid;
    private string $userName;
    private string $email;
    private int $age;
    private ?string $avatarUri;
    private array $roles;

    public function __construct(int $internalId, UuidInterface $userUuid, string $userName, string $email, int $age, ?string $avatarUri, array $roles)
    {
        $this->internalId = $internalId;
        $this->userUuid = $userUuid;
        $this->userName = $userName;
        $this->email = $email;
        $this->age = $age;
        $this->avatarUri = $avatarUri;
        $this->roles = $roles;
    }

    public function getInternalId(): int
    {
        return $this->internalId;
    }

    public function getUserUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): ?string
    {
        return null;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUser(): UserInterface
    {
        return $this;
    }
}
