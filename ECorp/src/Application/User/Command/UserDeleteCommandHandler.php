<?php

namespace ECorp\Application\User\Command;

use ECorp\Application\Query\User\UserQueryInterface;
use ECorp\DomainModel\User\User;
use ECorp\DomainModel\User\UserRepositoryInterface;

final class UserDeleteCommandHandler
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
     * @param UserDeleteCommand $user
     * @throws UserDeleteException
     */
    public function handle(UserDeleteCommand $user): void
    {
        if (null === $this->userQuery->getByUuid($user->getUuid()->getString())) {
            throw new UserDeleteException('The user you want to delete doesn\t exist!', 409);
        }

        $this->userRepository->delete($user->getUuid());
    }
}