<?php

namespace ECorp\Infrastructure\Persistence\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use ECorp\DomainModel\User\User;
use ECorp\DomainModel\User\UserRepositoryInterface;
use ECorp\DomainModel\Uuid;
use ECorp\Infrastructure\Facade\UserFacade;
use ECorp\Infrastructure\Persistence\Idp\Entity\User as UserEntity;
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
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function register(User $user): void
    {
        $this->getEntityManager()->persist(UserFacade::fromDomainUser($user));
        $this->getEntityManager()->flush();
    }

    public function update(User $user): void
    {
        // TODO: Implement update() method.
    }

    /**
     * @param Uuid $uuid
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Uuid $uuid): void
    {
        $entity = $this->getEntityManager()->getRepository(UserEntity::class)->findOneBy(['uuid' => $uuid->asString()]);

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
