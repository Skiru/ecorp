<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Security;

use ECorp\Application\User\Query\UserQueryInterface;
use ECorp\Infrastructure\Facade\UserFacade;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private const LOGIN_ROUTE_NAME = 'web_login_user';
    private const AUTHORIZE_ROUTE_NAME = 'fos_oauth_server_authorize';
    private const IDP_PROFILE_PAGE_ROUTE_NAME = 'idp_profile';
    public const DESTINATION_KEY = 'destination';

    private UserQueryInterface $userQuery;

    private RouterInterface $router;

    private CsrfTokenManagerInterface $csrfTokenManager;

    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserQueryInterface $userQuery, RouterInterface $router, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder, Security $security)
    {
        $this->userQuery = $userQuery;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request): bool
    {
        if (self::AUTHORIZE_ROUTE_NAME === $request->attributes->get('_route')) {
            $request->getSession()->set(self::DESTINATION_KEY, $request->getRequestUri());
        }

        return self::LOGIN_ROUTE_NAME === $request->attributes->get('_route') && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $userView = $this->userQuery->getAllByEmail($credentials['email']);
        if (!$userView) {
            throw new CustomUserMessageAuthenticationException('Email could not be found.');
        }

        if (!$this->passwordEncoder->isPasswordValid(UserFacade::toSecurityUser($userView), $credentials['password'])) {
            throw new CustomUserMessageAuthenticationException('Password does not match!');
        }

        return UserFacade::toPurplecloudsUser($userView);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($request->request->has('_target_path') && !empty($request->request->get('_target_path'))) {
            return new RedirectResponse($request->request->get('_target_path'));
        }

        if (self::AUTHORIZE_ROUTE_NAME === $request->attributes->get('_route')) {
            return new RedirectResponse($this->getAuthorizeUrl());
        }

        return new RedirectResponse($this->getIdpProfilePageUrl());
    }

    protected function getLoginUrl(array $params = []): string
    {
        return $this->router->generate(self::LOGIN_ROUTE_NAME);
    }

    private function getAuthorizeUrl(): string
    {
        return $this->router->generate(self::AUTHORIZE_ROUTE_NAME);
    }

    private function getIdpProfilePageUrl(): string
    {
        return $this->router->generate(self::IDP_PROFILE_PAGE_ROUTE_NAME);
    }
}