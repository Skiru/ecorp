<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Facade;

use ECorp\DomainModel\User\User;
use ECorp\Infrastructure\Persistence\Idp\Entity\User as UserEntity;
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
}
