<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Storage;

use DateTimeImmutable;
use ECorp\Infrastructure\Security\User\ECorpUserProviderInterface;
use ECorp\Infrastructure\Security\User\PurpleCloudsUser;
use Firebase\JWT\JWT;
use FOS\OAuthServerBundle\Model\AccessTokenManagerInterface;
use FOS\OAuthServerBundle\Model\AuthCodeManagerInterface;
use FOS\OAuthServerBundle\Model\ClientInterface;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use FOS\OAuthServerBundle\Model\RefreshTokenManagerInterface;
use FOS\OAuthServerBundle\Storage\OAuthStorage;
use InvalidArgumentException;
use OAuth2\Model\IOAuth2Client;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class IdpStorage extends OAuthStorage
{
    /**
     * @var ClientManagerInterface
     */
    protected $clientManager;

    /**
     * @var AccessTokenManagerInterface
     */
    protected $accessTokenManager;

    /**
     * @var RefreshTokenManagerInterface
     */
    protected $refreshTokenManager;

    /**
     * @var AuthCodeManagerInterface;
     */
    protected $authCodeManager;

    /**
     * @var ECorpUserProviderInterface
     */
    protected $userProvider;

    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @var array [uri] => GrantExtensionInterface
     */
    protected $grantExtensions;

    /**
     * @param ClientManagerInterface $clientManager
     * @param AccessTokenManagerInterface $accessTokenManager
     * @param RefreshTokenManagerInterface $refreshTokenManager
     * @param AuthCodeManagerInterface $authCodeManager
     * @param null|ECorpUserProviderInterface $userProvider
     * @param null|EncoderFactoryInterface $encoderFactory
     */
    public function __construct(
        ClientManagerInterface $clientManager,
        AccessTokenManagerInterface $accessTokenManager,
        RefreshTokenManagerInterface $refreshTokenManager,
        AuthCodeManagerInterface $authCodeManager,
        ECorpUserProviderInterface $userProvider,
        EncoderFactoryInterface $encoderFactory = null
    ) {
        $this->clientManager = $clientManager;
        $this->accessTokenManager = $accessTokenManager;
        $this->refreshTokenManager = $refreshTokenManager;
        $this->authCodeManager = $authCodeManager;
        $this->userProvider = $userProvider;
        $this->encoderFactory = $encoderFactory;

        $this->grantExtensions = [];
    }

    public function createAuthCode($code, IOAuth2Client $client, $data, $redirect_uri, $expires, $scope = null)
    {
        if (!$client instanceof ClientInterface) {
            throw new InvalidArgumentException('Client has to implement the ClientInterface');
        }

        $authCode = $this->authCodeManager->createAuthCode();
        $authCode->setToken($code);
        $authCode->setClient($client);
        /**
         * @var PurpleCloudsUser $data
         */
        $authCode->setUser($this->userProvider->loadUserByUsername($data->getUsername()));
        $authCode->setRedirectUri($redirect_uri);
        $authCode->setExpiresAt($expires);
        $authCode->setScope($scope);
        $authCode->setUuid(Uuid::uuid4());

        $this->authCodeManager->updateAuthCode($authCode);

        return $authCode;
    }

    public function createAccessToken($tokenString, IOAuth2Client $client, $data, $expires, $scope = null)
    {
        if (!$client instanceof ClientInterface) {
            throw new InvalidArgumentException('Client has to implement the ClientInterface');
        }

        $token = $this->accessTokenManager->createToken();
        $token->setToken($tokenString);
        $token->setClient($client);
        $token->setExpiresAt($expires);
        $token->setScope($scope);
        $token->setUuid(Uuid::uuid4());

        if (null !== $data) {
            $token->setUser($this->userProvider->loadUserById($data->getId()));
        }

        $this->accessTokenManager->updateToken($token);

        return $token;
    }

    public function createRefreshToken($tokenString, IOAuth2Client $client, $data, $expires, $scope = null)
    {
        if (!$client instanceof ClientInterface) {
            throw new InvalidArgumentException('Client has to implement the ClientInterface');
        }

        $token = $this->refreshTokenManager->createToken();
        $token->setToken($tokenString);
        $token->setClient($client);
        $token->setExpiresAt($expires);
        $token->setScope($scope);
        $token->setUuid(Uuid::uuid4());

        if (null !== $data) {
            $token->setUser($data);
        }

        $this->refreshTokenManager->updateToken($token);

        return $token;
    }

    /**
     * @return AuthCodeManagerInterface
     */
    public function getAuthCodeManager(): AuthCodeManagerInterface
    {
        return $this->authCodeManager;
    }
}
