<?php

declare(strict_types=1);

namespace ECorp\DomainModel\Client;

use ECorp\DomainModel\Uuid;

interface ClientRepositoryInterface
{
    public function findAllClients(): array;
}