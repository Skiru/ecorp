<?php

namespace ECorp\Application\User\Command;

use ECorp\Application\Query\User\UserQueryInterface;
use ECorp\DomainModel\BusinessRequirementsConstants;
use ECorp\DomainModel\User\UserRepositoryInterface;

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
     * UserRegisterCommandHandler constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserQueryInterface $userQuery
     */
    public function __construct(UserRepositoryInterface $userRepository, UserQueryInterface $userQuery)
    {
        $this->userRepository = $userRepository;
        $this->userQuery = $userQuery;
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

        if (null !== $this->userQuery->getByEmail($command->getUser()->getEmail()->getEmail())) {
            throw new UserRegisterException('User with this email already exists!', 409);
        }

        $this->userRepository->register($command->getUser());
    }
}
