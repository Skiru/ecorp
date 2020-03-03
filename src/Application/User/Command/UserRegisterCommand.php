<?php

declare(strict_types=1);

namespace ECorp\Application\User\Command;

use ECorp\DomainModel\User\User;

final class UserRegisterCommand
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
