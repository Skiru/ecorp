<?php

namespace ECorp\Application\Query\User;

interface UserQueryInterface
{
    /**
     * @return int
     */
    public function count(): int;

    /**
     * @param string $uuid
     * @return UserView|null
     */
    public function getByUuid(string $uuid): ?UserView;

    /**
     * @return array
     */
    public function getAll(): array;
}
