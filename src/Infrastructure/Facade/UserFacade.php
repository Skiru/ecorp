<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Facade;

use ECorp\Application\Query\User\SecurityUserDataView;
use ECorp\DomainModel\User\User;
use ECorp\Infrastructure\Persistence\Idp\Entity\User as UserEntity;
use ECorp\Infrastructure\Security\User\PurpleCloudsUser;
use ECorp\Infrastructure\Security\User\SecurityUser;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFacade
{
    /**
     * @param User $user
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return UserEntity
     */
    public static function fromDomainUser(User $user, UserPasswordEncoderInterface $passwordEncoder): UserEntity
    {
        $userEntity = new UserEntity();
        $password = $user->getPassword()->asString();
        return $userEntity
            ->setUuid($user->getUuid()->asString())
            ->setEmail($user->getEmail()->asString())
            ->setAge($user->getAge()->asInt())
            ->setUsername($user->getUsername()->asString())
            ->setPassword($passwordEncoder->encodePassword($userEntity, $password));
    }

    public static function toPurplecloudsUser(SecurityUserDataView $userView): PurpleCloudsUser
    {
        return new PurpleCloudsUser(
            Uuid::fromString($userView->getUuid()),
            $userView->getEmail(),
            $userView->getRoles(),
            serialize($userView)
        );
    }

    public static function toSecurityUser(SecurityUserDataView $userView): SecurityUser
    {
        return new SecurityUser(
            Uuid::fromString($userView->getUuid()),
            $userView->getId(),
            $userView->getEmail(),
            $userView->getRoles(),
            $userView->getPassword()
        );
    }
}
