<?php

declare(strict_types=1);

namespace ECorp\DomainModel\Client;

use ECorp\DomainModel\Uuid;

class Client
{
    private Uuid $uuid;

    private int $id;

    private string $scopes;

    private string $publicId;

    private string $secret;

    /**
     * @var string[]
     */
    private array $redirectUri;

    /**
     * @var string[]
     */
    private array $grantTypes;

    public function __construct(
        Uuid $uuid,
        int $id,
        string $scopes,
        string $publicId,
        string $secret,
        array $redirectUri,
        array $grantTypes
    ) {
        $this->uuid = $uuid;
        $this->id = $id;
        $this->scopes = $scopes;
        $this->publicId = $publicId;
        $this->secret = $secret;
        $this->redirectUri = $redirectUri;
        $this->grantTypes = $grantTypes;
    }
}
