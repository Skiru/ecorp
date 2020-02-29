<?php

declare(strict_types=1);

namespace ECorp\Application\User\Command;

use ECorp\Application\Event\AggregateRoot\AggregateRootRepositoryInterface;
use ECorp\Application\Query\User\UserQueryInterface;
use ECorp\DomainModel\Assert\AssertException;
use ECorp\DomainModel\BusinessRequirementsConstants;
use ECorp\DomainModel\User\UserRepositoryInterface;
use ECorp\Infrastructure\Facade\UserFacade;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserRegisterCommandHandler
{
    private UserRepositoryInterface $userRepository;

    private UserQueryInterface $userQuery;

    private AggregateRootRepositoryInterface $userAggregateRootRepository;

    public function __construct(UserRepositoryInterface $userRepository, UserQueryInterface $userQuery, AggregateRootRepositoryInterface $userAggregateRootRepository)
    {
        $this->userRepository = $userRepository;
        $this->userQuery = $userQuery;
        $this->userAggregateRootRepository = $userAggregateRootRepository;
    }

    /**
     * @param UserRegisterCommand $command
     * @throws UserRegisterException
     * @throws AssertException
     */
    public function handle(UserRegisterCommand $command)
    {
        if ($this->userQuery->count() > BusinessRequirementsConstants::MAX_NUMBER_OF_COMPANY_USERS) {
            throw new UserRegisterException('There is no more available place for the user!', 409);
        }

        if (null !== $this->userQuery->getByEmail($command->getUser()->getEmail()->asString())) {
            throw new UserRegisterException('User with this email already exists!', 409);
        }

        $this->userRepository->register($command->getUser());

        /*TODO Agreegate root not now ;(
        $aggregateRootUuid = new Uuid($command->getUser()->getUuid()->asString());
        try {
            $aggregateRoot = new UserAggregateRoot($aggregateRootUuid);
            $aggregateRoot->registerUser($command->getUser());
        } catch (UnknownDomainEventType $domainEventType) {
            throw new UserRegisterException('Internal error');
        }

        $this->userAggregateRootRepository->persist($aggregateRoot);*/
    }
}
