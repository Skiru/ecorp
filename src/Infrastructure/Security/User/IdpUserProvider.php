<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Security\User;

use ECorp\Infrastructure\Persistence\Idp\Entity\User;
use ECorp\Infrastructure\Persistence\Repository\UserDbRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class IdpUserProvider implements ECorpUserProviderInterface
{
    private UserDbRepository $userRepository;

    public function __construct(UserDbRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername($username)
    {
        return $this->userRepository->findOneBy(['email' => $username]);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->userRepository->findOneBy(['username' => $user->getUsername()]);
    }

    public function loadUserById(int $id): UserInterface
    {
        return $this->userRepository->findOneBy(['id' => $id]);
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
