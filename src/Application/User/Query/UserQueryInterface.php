<?php

declare(strict_types=1);

namespace ECorp\Application\User\Query;

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

    /**
     * @param string $email
     * @return UserView|null
     */
    public function getByEmail(string $email): ?UserView;

    /**
     * @param string $email
     * @return SecurityUserDataView|null
     */
    public function getAllByEmail(string $email): ?SecurityUserDataView;
}
