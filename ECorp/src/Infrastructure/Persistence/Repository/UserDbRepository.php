<?php

namespace ECorp\Infrastructure\Persistence\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use ECorp\DomainModel\User\User;
use ECorp\DomainModel\User\UserRepositoryInterface;
use ECorp\Infrastructure\Facade\UserFacade;
use ECorp\Infrastructure\Persistence\Entity\User as UserEntity;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserDbRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    /**
     * UserDbRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function register(User $user): void
    {
        $this->getEntityManager()->persist(UserFacade::fromDomainUser($user));
        $this->getEntityManager()->flush();
    }
}