<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Idp;

use ECorp\DomainModel\Client\ClientRepositoryInterface;

class ClientHandler
{
    private ClientRepositoryInterface $repository;

    public function __construct(ClientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function findAllClients(): array
    {
        return $this->repository->findAllClients();
    }
}