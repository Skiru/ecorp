<?php

namespace ECorp\UI\Api;

use ECorp\Application\Query\User\UserQueryInterface;
use ECorp\Application\User\Command\UserRegisterCommand;
use ECorp\DomainModel\Assert\AssertException;
use ECorp\DomainModel\User\Age;
use ECorp\DomainModel\User\Email;
use ECorp\DomainModel\User\User;
use ECorp\DomainModel\User\Username;
use ECorp\DomainModel\User\Uuid as DomainUuid;
use ECorp\Infrastructure\CommandBus\CommandBusInterface;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    /**
     * @var UserQueryInterface
     */
    private $userQuery;

    /**
     * UserController constructor.
     * @param CommandBusInterface $commandBus
     * @param UserQueryInterface $userQuery
     */
    public function __construct(CommandBusInterface $commandBus, UserQueryInterface $userQuery)
    {
        $this->commandBus = $commandBus;
        $this->userQuery = $userQuery;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AssertException
     */
    public function registerUser(Request $request): JsonResponse
    {
        $json = json_decode($request->getContent(), true);
        $uuid = Uuid::uuid4()->toString();

        try {
            $user = new User(
                new Email($json['email']),
                new Username($json['username']),
                new Age($json['age']),
                new DomainUuid($uuid)
            );

            $userRegisterCommand = new UserRegisterCommand($user);

            $this->commandBus->handle($userRegisterCommand);

            return new JsonResponse(['uuid' => $uuid], 201);
        } catch (InvalidArgumentException $argumentException) {
            return new JsonResponse(['payload' => $argumentException->getMessage()], 400);
        }
    }

    /**
     * @return JsonResponse
     */
    public function countUsers(): JsonResponse
    {
        return new JsonResponse(['users' => $this->userQuery->count()]);
    }

    /**
     * @return JsonResponse
     */
    public function listUsers(): JsonResponse
    {
        return new JsonResponse($this->userQuery->getAll());
    }

    /**
     * @param string $uuid
     * @return JsonResponse
     */
    public function getUserByUuid(string $uuid): JsonResponse
    {
        if (null === $this->userQuery->getByUuid($uuid)) {
            return new JsonResponse(['payload' => 'no users found'], 404);
        }

        return new JsonResponse($this->userQuery->getByUuid($uuid));
    }
}
