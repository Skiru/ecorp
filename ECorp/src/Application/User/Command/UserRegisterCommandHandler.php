<?php

namespace ECorp\Application\User\Command;

use ECorp\DomainModel\User\UserRepositoryInterface;

final class UserRegisterCommandHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserRegisterCommandHandler constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserRegisterCommand $command
     */
    public function handle(UserRegisterCommand $command)
    {
        $this->userRepository->register($command->getUser());
    }
}
