<?php

namespace ECorp\Application\User\Command;

use ECorp\DomainModel\User\Uuid;

final class UserDeleteCommand
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * DeleteUserCommand constructor.
     * @param Uuid $uuid
     */
    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }
}
