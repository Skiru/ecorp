<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Uuid;
use ECorp\Infrastructure\Persistence\Repository\UserRepositoryException;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     *
     * @return void
     *
     * @throws UserRepositoryException
     */
    public function register(User $user): void;

    /**
     * @param User $user
     */
    public function update(User $user): void;

    /**
     * @param Uuid $uuid
     */
    public function delete(Uuid $uuid): void;
}
