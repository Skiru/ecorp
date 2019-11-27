<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Uuid;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return void
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