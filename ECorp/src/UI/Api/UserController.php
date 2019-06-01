<?php

namespace ECorp\UI\Api;

use ECorp\Application\User\Command\UserRegisterCommand;
use ECorp\DomainModel\User\Age;
use ECorp\DomainModel\User\Email;
use ECorp\DomainModel\User\Username;
use ECorp\Infrastructure\CommandBus\CommandBusInterface;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
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
     * @throws Exception
     */
    public function registerUser(Request $request): JsonResponse
    {
        $uuid = Uuid::uuid4();
        try {
            $userRegisterCommand = new UserRegisterCommand(
                new Email($request->get('email')),
                new Username($request->get('username')),
                new Age($request->get('age')),
                $uuid
            );

            $this->commandBus->handle($userRegisterCommand);

            return new JsonResponse(['uuid' => $uuid], 201);
        } catch (InvalidArgumentException $argumentException) {
            return new JsonResponse($argumentException->getMessage(), 401);
        }
    }

    /**
     * @return JsonResponse
     */
    public function getAllUsers(): JsonResponse
    {
        return new JsonResponse([
            'users' => [
                'mateusz' => 'serialized_mateusz_user_data'
            ]
        ]);
    }

}
