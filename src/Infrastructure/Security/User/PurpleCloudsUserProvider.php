<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Security\User;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class PurpleCloudsUserProvider implements UserProviderInterface
{
    /**
     * @inheritDoc
     */
    public function loadUserByUsername($username): UserInterface
    {
        throw new UsernameNotFoundException('Can not find user by name');
    }

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function supportsClass($class): bool
    {
        return PurpleCloudsUser::class === $class;
    }
}