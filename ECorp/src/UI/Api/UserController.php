<?php

namespace ECorp\UI\Api;

use ECorp\Application\User\Command\UserRegisterCommand;
use ECorp\DomainModel\User\Age;
use ECorp\DomainModel\User\Email;
use ECorp\DomainModel\User\Username;
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
     * UserController constructor.
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function registerUser(Request $request): JsonResponse
    {
        $json = json_decode($request->getContent(), true);

        try {
            $uuid = Uuid::uuid4();
            $email = new Email($json['email']);
            $username = new Username($json['username']);
            $age = new Age($json['age']);

            $userRegisterCommand = new UserRegisterCommand(
                $email,
                $username,
                $age,
                $uuid
            );

            $this->commandBus->handle($userRegisterCommand);

            return new JsonResponse(['uuid' => $uuid], 201);
        } catch (InvalidArgumentException $argumentException) {
            return new JsonResponse(['payload' => $argumentException->getMessage()], 400);
        }
    }

    /**
     * @return JsonResponse
     */
    public function listUsers(): JsonResponse
    {
        return new JsonResponse([
            'users' => [
                'mateusz' => 'serialized_mateusz_user_data'
            ]
        ]);
    }

}
