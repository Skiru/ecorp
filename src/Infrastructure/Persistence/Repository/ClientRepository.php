<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Persistence\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use ECorp\DomainModel\Client\ClientRepositoryInterface;
use ECorp\Infrastructure\Persistence\Idp\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findAllClients(): array
    {
        return $this->findAll();
    }
}