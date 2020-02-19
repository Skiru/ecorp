<?php

namespace ECorp\UI\Frontend;

use ECorp\Application\Query\User\UserQueryInterface;
use ECorp\Application\User\Command\UserRegisterCommand;
use ECorp\Application\User\Command\UserRegisterException;
use ECorp\DomainModel\Assert\AssertException;
use ECorp\DomainModel\User\Age;
use ECorp\DomainModel\User\Email;
use ECorp\DomainModel\User\User;
use ECorp\DomainModel\User\Username;
use ECorp\DomainModel\Uuid as DomainUuid;
use ECorp\Infrastructure\CommandBus\CommandBusInterface;
use ECorp\Infrastructure\Form\User\UserFormModel;
use ECorp\Infrastructure\Form\User\UserType;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IdpController extends AbstractController
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

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    public function register(Request $request): Response
    {
        $userFormModel = new UserFormModel();
        $form = $this->createForm(UserType::class, $userFormModel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $uuid = Uuid::uuid4()->toString();

            try {
                $user = new User(
                    new Email($userFormModel->email),
                    new Username($userFormModel->username),
                    new Age($userFormModel->age),
                    new DomainUuid($uuid)
                );

                $userRegisterCommand = new UserRegisterCommand($user);

                $this->commandBus->handle($userRegisterCommand);

                return $this->redirectToRoute('web_login_user');
            } catch (AssertException $argumentException) {
                return $this->render('security/register.html.twig', [
                    'form' => $form->createView(),
                    'error' => $argumentException->getMessage()
                ]);
            } catch (UserRegisterException $userRegisterException) {
                return $this->render('security/register.html.twig', [
                    'form' => $form->createView(),
                    'error' => $userRegisterException->getMessage()
                ]);
            }
        }

        return $this->render('security/register.html.twig', [
           'form' => $form->createView()
        ]);
    }

    public function profile(): Response
    {
        return $this->render('admin/profile.html.twig', []);
    }

    /**
     * @return JsonResponse
     */
    public function homepage(): JsonResponse
    {
        return new JsonResponse([
            'Message' => 'purple clouds idp homepage'
        ]);
    }
}