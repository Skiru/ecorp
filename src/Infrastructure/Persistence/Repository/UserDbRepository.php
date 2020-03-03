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
use Exception;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Throwable;

class UserDbRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @param RegistryInterface $registry
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(RegistryInterface $registry, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($registry, UserEntity::class);
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     *
     * @throws UserRepositoryException
     */
    public function register(User $user): void
    {
        try {
            $this->getEntityManager()->persist(UserFacade::fromDomainUser($user, $this->passwordEncoder));
            $this->getEntityManager()->flush();
        } catch (Throwable $exception) {
            throw new UserRepositoryException($exception->getMessage());
        }
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
