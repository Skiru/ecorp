<?php

namespace ECorp\DomainModel\User;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return void
     */
    public function register(User $user): void;
}
