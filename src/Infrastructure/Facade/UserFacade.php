<?php

namespace ECorp\Infrastructure\Facade;

use ECorp\DomainModel\User\User;
use ECorp\Infrastructure\Persistence\Idp\Entity\User as UserEntity;

class UserFacade
{
    /**
     * @param User $user
     * @return UserEntity
     */
    public static function fromDomainUser(User $user): UserEntity
    {
        return ($userEntity = new UserEntity())
            ->setUuid($user->getUuid()->asString())
            ->setUsername($user->getUsername()->asString())
            ->setEmail($user->getEmail()->asString())
            ->setAge($user->getAge()->asInt());
    }
}
