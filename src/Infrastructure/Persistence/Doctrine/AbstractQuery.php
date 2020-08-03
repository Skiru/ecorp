<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Connection;

abstract class AbstractQuery
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}
