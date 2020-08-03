<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Persistence\Repository;

use ECorp\Infrastructure\Persistence\Repository\CannotPersistException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use ECorp\Infrastructure\Persistence\Idp\Entity\RegisteredClient;

class RegisteredClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegisteredClient::class);
    }

    /**
     * @param RegisteredClient $client
     * @throws CannotPersistException
     */
    public function authorizeClient(RegisteredClient $client)
    {
        try {
            $this->getEntityManager()->persist($client);
            $this->getEntityManager()->flush();
        } catch (ORMException $e) {
            throw new CannotPersistException('Cannot authorize client');
        }
    }
}