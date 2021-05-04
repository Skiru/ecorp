<?php

declare(strict_types=1);

namespace ECorp\UI\Frontend;

use ECorp\Application\Client\Query\GrantedClientQueryInterface;
use ECorp\Application\Client\Query\ClientQueryInterface;
use ECorp\Application\User\Query\UserQueryInterface;
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
use ECorp\Infrastructure\Security\LoginFormAuthenticator;
use ECorp\Infrastructure\Security\User\PurpleCloudsUser;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IdpController extends AbstractController
{
    private CommandBusInterface $commandBus;

    private UserQueryInterface $userQuery;

    private ClientManagerInterface $clientManager;

    private ClientQueryInterface $clientQuery;

    private GrantedClientQueryInterface $grantedClientQuery;

    public function __construct(
        CommandBusInterface $commandBus,
        UserQueryInterface $userQuery,
        ClientManagerInterface $clientManager,
        ClientQueryInterface $clientQuery,
        GrantedClientQueryInterface $grantedClientQuery
    ) {
        $this->commandBus = $commandBus;
        $this->userQuery = $userQuery;
        $this->clientManager = $clientManager;
        $this->clientQuery = $clientQuery;
        $this->grantedClientQuery = $grantedClientQuery;
    }

    public function homepage(): Response
    {
        return $this->render('idp/homepage.html.twig');
    }

    public function login(
        Request $request,
        AuthenticationUtils $authenticationUtils,
        AuthorizationCheckerInterface $authorizationChecker
    ): Response {

        if ($authorizationChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('idp_profile');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $targetPath = $this->getTargetPath($request);
        $this->removeTargetPath($request);

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'target_path' => $targetPath
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

    public function user(): Response
    {
        return $this->render('admin/user.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    public function client(): Response
    {
        $idpClientModel = new IdpClientModel();
        $clientCreateForm = $this->createForm(IdpClientType::class, $idpClientModel);
        $clients = $this->clientQuery->getAll();

        return $this->render('admin/clients.html.twig', [
            'idp_client_form' => $clientCreateForm->createView(),
            'clients' => $clients
        ]);
    }

    public function grantedApplications(): Response
    {
        $grantedClients = $this->grantedClientQuery->getAll();

        return $this->render('admin/granted_applications.html.twig', [
            'granted_clients' => $grantedClients
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

            $client->setRedirectUris(
                explode(',', $idpClientModel->redirectUri)
            );
            $client->setAllowedGrantTypes([$idpClientModel->grantType]);
            $client->setUuid(Uuid::uuid4());
            $client->setScopes('profile');
            $client->setName($idpClientModel->name);
            $this->clientManager->updateClient($client);
        }

        return $this->redirectToRoute('idp_profile_client');
    }

    private function getTargetPath(Request $request): ?string
    {
        return $request->getSession()->has(LoginFormAuthenticator::DESTINATION_KEY)
            ? $request->getSession()->get(LoginFormAuthenticator::DESTINATION_KEY)
            : null;
    }

    private function removeTargetPath(Request $request): void
    {
        $request->getSession()->remove(LoginFormAuthenticator::DESTINATION_KEY);
    }
}
