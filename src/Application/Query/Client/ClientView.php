<?php

declare(strict_types=1);

namespace ECorp\Application\Query\Client;

use ECorp\DomainModel\Uuid;
use JsonSerializable;

class ClientView implements JsonSerializable
{
    private Uuid $uuid;

    private string $scopes;

    private string $clientId;

    private string $secret;

    private string $name;

    /**
     * @var string[]
     */
    private array $redirectUri;

    /**
     * @var string[]
     */
    private array $grantTypes;

    /**
     * @param Uuid $uuid
     * @param string $scopes
     * @param string $clientId
     * @param string $secret
     * @param string[] $redirectUri
     * @param string[] $grantTypes
     */
    public function __construct(
        Uuid $uuid,
        string $scopes,
        string $clientId,
        string $secret,
        array $redirectUri,
        array $grantTypes,
        string $name
    ) {
        $this->uuid = $uuid;
        $this->scopes = $scopes;
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->redirectUri = $redirectUri;
        $this->grantTypes = $grantTypes;
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid->asString(),
            'scopes' => $this->scopes,
            'client_id' => $this->clientId,
            'client_secret' => $this->secret,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => $this->grantTypes,
            'name' => $this->name
        ];
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getScopes(): string
    {
        return $this->scopes;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @return string[]
     */
    public function getRedirectUri(): array
    {
        return $this->redirectUri;
    }

    /**
     * @return string[]
     */
    public function getGrantTypes(): array
    {
        return $this->grantTypes;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
