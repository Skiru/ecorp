<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface ECorpUserProviderInterface extends UserProviderInterface
{
    public function loadUserById(int $id): ?UserInterface;
}
