<?php

namespace ECorp\Infrastructure\Facade;

use ECorp\DomainModel\User\User;
use ECorp\Infrastructure\Persistence\Entity\User as UserEntity;

class UserFacade
{
    /**
     * @param User $user
     * @return UserEntity
     */
    public static function fromDomainUser(User $user): UserEntity
    {
        return ($userEntity = new UserEntity())
            ->setUuid($user->getUuid())
            ->setUsername($user->getUsername()->getUsername())
            ->setEmail($user->getEmail()->getEmail())
            ->setAge($user->getAge()->getAge());
    }
}
