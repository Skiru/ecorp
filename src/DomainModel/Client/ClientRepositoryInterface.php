<?php

declare(strict_types=1);

namespace ECorp\DomainModel\Client;

interface ClientRepositoryInterface
{
    public function findAllClients(): array;
}