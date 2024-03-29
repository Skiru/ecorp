<?php

namespace ECorp\UI\Api;

use ECorp\Application\User\Query\UserQueryInterface;
use ECorp\Application\User\Command\UserDeleteCommand;
use ECorp\Application\User\Command\UserDeleteException;
use ECorp\Application\User\Command\UserRegisterCommand;
use ECorp\Application\User\Command\UserRegisterException;
use ECorp\DomainModel\Assert\AssertException;
use ECorp\DomainModel\User\Age;
use ECorp\DomainModel\User\Email;
use ECorp\DomainModel\User\Password;
use ECorp\DomainModel\User\User;
use ECorp\DomainModel\User\Username;
use ECorp\DomainModel\Uuid as DomainUuid;
use ECorp\Infrastructure\CommandBus\CommandBusInterface;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    private CommandBusInterface $commandBus;

    private UserQueryInterface $userQuery;

    public function __construct(CommandBusInterface $commandBus, UserQueryInterface $userQuery)
    {
        $this->commandBus = $commandBus;
        $this->userQuery = $userQuery;
    }

    /**
     * @throws Exception
     */
    public function registerUser(Request $request): JsonResponse
    {
        $json = json_decode($request->getContent(), true);
        $uuid = Uuid::uuid4()->toString();

        try {
            $user = new User(
                new DomainUuid($uuid),
                new Email($json['email']),
                new Username($json['username']),
                new Age($json['age']),
                new Password($json['password'])
            );

            $userRegisterCommand = new UserRegisterCommand($user);

            $this->commandBus->handle($userRegisterCommand);

            return new JsonResponse(['uuid' => $uuid], 201);
        } catch (AssertException $argumentException) {
            return new JsonResponse(['payload' => $argumentException->getMessage()], 400);
        } catch (UserRegisterException $userRegisterException) {
            return new JsonResponse(['payload' => $userRegisterException->getMessage()], $userRegisterException->getCode());
        }
    }

    /**
     * @throws AssertException
     */
    public function deleteUser(string $uuid): JsonResponse
    {
        try {
            $userDeleteCommand = new UserDeleteCommand(
                new DomainUuid($uuid)
            );

            $this->commandBus->handle($userDeleteCommand);

            return new JsonResponse(['payload' => sprintf('User with uuid: %s has been deleted successfully', $uuid)]);
        } catch (AssertException $assertException) {
            return new JsonResponse(['payload' => $assertException->getMessage()], 409);
        } catch (UserDeleteException $deleteException) {
            return new JsonResponse(['payload' => $deleteException->getMessage()], $deleteException->getCode());
        }
    }

    public function countUsers(): JsonResponse
    {
        return new JsonResponse(['users' => $this->userQuery->count()]);
    }

    public function listUsers(): JsonResponse
    {
        return new JsonResponse($this->userQuery->getAll());
    }

    public function getUserByUuid(string $uuid): JsonResponse
    {
        if (null === $this->userQuery->getByUuid($uuid)) {
            return new JsonResponse(['payload' => 'no users found'], 404);
        }

        return new JsonResponse($this->userQuery->getByUuid($uuid));
    }
}
