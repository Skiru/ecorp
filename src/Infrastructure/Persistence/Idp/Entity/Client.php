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
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var UuidInterface
     *
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $uuid;

    /**
     * @var string
     * @ORM\Column(type="string", name="scope")
     */
    private $scope;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}