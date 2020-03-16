<?php

declare(strict_types=1);

namespace ECorp\UI\Frontend;

use ECorp\Application\Query\Client\ClientQueryInterface;
use ECorp\Application\Query\User\UserQueryInterface;
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
use ECorp\Infrastructure\Form\IdpClient\IdpClientModel;
use ECorp\Infrastructure\Form\IdpClient\IdpClientType;
use ECorp\Infrastructure\Form\User\UserFormModel;
use ECorp\Infrastructure\Form\User\UserType;
use ECorp\Infrastructure\Idp\ClientHandler;
use ECorp\Infrastructure\Security\User\PurpleCloudsUser;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IdpController extends AbstractController
{
    private CommandBusInterface $commandBus;

    private UserQueryInterface $userQuery;

    private ClientManagerInterface $clientManager;

    private ClientHandler $clientHandler;

    private ClientQueryInterface $clientQuery;

    public function __construct(CommandBusInterface $commandBus, UserQueryInterface $userQuery, ClientManagerInterface $clientManager, ClientHandler $clientHandler, ClientQueryInterface $clientQuery)
    {
        $this->commandBus = $commandBus;
        $this->userQuery = $userQuery;
        $this->clientManager = $clientManager;
        $this->clientHandler = $clientHandler;
        $this->clientQuery = $clientQuery;
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
                    new DomainUuid($uuid),
                    new Email($userFormModel->email),
                    new Username($userFormModel->username),
                    new Age($userFormModel->age),
                    new Password($userFormModel->plainPassword)
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

    /**
     * @return Response
     */
    public function profile(): Response
    {
        $idpClientModel = new IdpClientModel();
        $clientCreateForm = $this->createForm(IdpClientType::class, $idpClientModel);
        $clients = $this->clientQuery->getAll();

        return $this->render('admin/profile.html.twig', [
            'user' => $this->getUser(),
            'idp_client_form' => $clientCreateForm->createView(),
            'clients' => $clients
        ]);
    }

    public function createIdpClient(Request $request): Response
    {
        $idpClientModel = new IdpClientModel();
        $clientCreateForm = $this->createForm(IdpClientType::class, $idpClientModel);
        $clientCreateForm->handleRequest($request);

        if ($clientCreateForm->isSubmitted() && $clientCreateForm->isValid()) {
            //TODO add here command construction

            $client = $this->clientManager->createClient();
            $client->setRedirectUris([$idpClientModel->redirectUri]);
            $client->setAllowedGrantTypes([$idpClientModel->grantType]);
            /** @var PurpleCloudsUser $user */
            $user = $this->getUser();
            $client->setUuid(Uuid::uuid4());
            $client->setScopes('profile');
            $this->clientManager->updateClient($client);
        }

        return $this->redirectToRoute('idp_profile');
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
