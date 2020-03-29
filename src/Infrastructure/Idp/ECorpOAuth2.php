<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Idp;

use DateTimeImmutable;
use ECorp\Infrastructure\Storage\IdpStorage;
use Firebase\JWT\JWT;
use OAuth2\OAuth2;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class ECorpOAuth2 extends OAuth2
{
    private IdpStorage $idpStorage;

    private UserInterface $user;

    public function __construct(IdpStorage $idpStorage)
    {
        parent::__construct($idpStorage);
        $this->idpStorage = $idpStorage;
    }

    protected function genAccessToken(): string
    {
        $privateKey = file_get_contents('jwt.pem', true);
        $payload = [
            "user" => $this->user->getUuid(),
            "iss" => "ecorp.purpleclouds.pl",
            "aud" => "blog.purpleclouds.pl",
            "iat" => (new DateTimeImmutable())->getTimestamp(),
            "nbf" => (new DateTimeImmutable('-10 days'))->getTimestamp(),
            "jti" => Uuid::uuid4()
        ];

       return JWT::encode($payload, $privateKey);
    }

    protected function getAuthorizationHeader(Request $request)
    {
        $code = $request->get('code');
        $authCode = $this->idpStorage->getAuthCodeManager()->findAuthCodeByToken($code);
        $this->user = $authCode->getUser();

        return array(
            'PHP_AUTH_USER' => $request->server->get('PHP_AUTH_USER'),
            'PHP_AUTH_PW' => $request->server->get('PHP_AUTH_PW'),
        );
    }
}
