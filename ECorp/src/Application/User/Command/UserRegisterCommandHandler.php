<?php

namespace ECorp\Application\User\Command;

use ECorp\Application\Event\AggregateRoot\AggregateRootRepositoryInterface;
use ECorp\Application\Query\User\UserQueryInterface;
use ECorp\DomainModel\BusinessRequirementsConstants;
use ECorp\DomainModel\User\Event\UnknownDomainEventType;
use ECorp\Application\Event\AggregateRoot\UserAggregateRoot;
use ECorp\DomainModel\User\UserRepositoryInterface;
use ECorp\DomainModel\Uuid;

final class UserRegisterCommandHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserQueryInterface
     */
    private $userQuery;

    /**
     * @var AggregateRootRepositoryInterface
     */
    private $userAggregateRootRepository;

    /**
     * UserRegisterCommandHandler constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserQueryInterface $userQuery
     * @param AggregateRootRepositoryInterface $aggregateRootRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserQueryInterface $userQuery,
        AggregateRootRepositoryInterface $aggregateRootRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userQuery = $userQuery;
        $this->userAggregateRootRepository = $aggregateRootRepository;
    }

    /**
     * @param UserRegisterCommand $command
     * @throws UserRegisterException
     */
    public function handle(UserRegisterCommand $command)
    {
        if ($this->userQuery->count() > BusinessRequirementsConstants::MAX_NUMBER_OF_COMPANY_USERS) {
            throw new UserRegisterException('There is no more available place for the user!', 409);
        }

        //Tworzenie customowych kodów błedow
        if (null !== $this->userQuery->getByEmail($command->getUser()->getEmail()->getEmail())) {
            throw new UserRegisterException('User with this email already exists!', 409);
        }

        //Nie zapisuj od razu do repository, robimy evenciki! Zmiana 1.
//        $this->userRepository->register($command->getUser());

        $aggregateRootUuid = new Uuid(\Ramsey\Uuid\Uuid::uuid4()->toString());
        try {
            $aggregateRoot = new UserAggregateRoot($aggregateRootUuid);
            $aggregateRoot->registerUser($command->getUser());
        } catch (UnknownDomainEventType $domainEventType) {
            throw new UserRegisterException('Internal error');
        }

        $this->userAggregateRootRepository->persist($aggregateRoot);
    }
}
