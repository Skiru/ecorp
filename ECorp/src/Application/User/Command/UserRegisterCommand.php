<?php

namespace ECorp\Application\User\Command;

use ECorp\DomainModel\User\User;

final class UserRegisterCommand
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserRegisterCommand constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
