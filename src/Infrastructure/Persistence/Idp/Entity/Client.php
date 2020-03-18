<?php

namespace ECorp\Infrastructure\Persistence\Idp\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 *
 * THIS IS AN APPLICATION DO NOT MISUNDERSTAND CLIENT == APPLICATION
 *
 * @ORM\Entity
 */
class Client extends BaseClient
{
    /**
     * @var UuidInterface
     *
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $uuid;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="scopes")
     */
    private $scopes;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @param UuidInterface $uuid
     */
    public function setUuid(UuidInterface $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @param string $scopes
     */
    public function setScopes(string $scopes): void
    {
        $this->scopes = $scopes;
    }
}
