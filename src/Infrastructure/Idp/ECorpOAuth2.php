<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Idp;

use DateTimeImmutable;
use ECorp\Infrastructure\Storage\IdpStorage;
use Firebase\JWT\JWT;
use OAuth2\OAuth2;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Security;

class ECorpOAuth2 extends OAuth2
{
    private IdpStorage $idpStorage;

    private Security $security;

    public function __construct(IdpStorage $idpStorage, Security $security)
    {
        parent::__construct($idpStorage);
        $this->security = $security;
    }

    protected function genAccessToken(): string
    {
        $privateKey = file_get_contents('jwt.pem', true);
        $payload = [
            "user" => $this->security->getUser()->getUserUuid(),
            "iss" => "ecorp.purpleclouds.pl",
            "aud" => "blog.purpleclouds.pl",
            "iat" => (new DateTimeImmutable())->getTimestamp(),
            "nbf" => (new DateTimeImmutable('-10 days'))->getTimestamp(),
            "jti" => Uuid::uuid4()
        ];

        return JWT::encode($payload, $privateKey, 'HS256');
    }


}
