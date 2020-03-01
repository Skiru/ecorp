<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Security\User;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface ECorpIdpUserInterface extends UserInterface
{
    public function getUserUuid(): UuidInterface;
}