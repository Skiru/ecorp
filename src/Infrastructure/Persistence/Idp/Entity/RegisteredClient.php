<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Persistence\Idp\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Model\ClientInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="registered_clients")
 * @ORM\Entity(repositoryClass="ECorp\Infrastructure\Persistence\Repository\RegisteredClientRepository")
 */
class RegisteredClient
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
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private bool $isGranted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private bool $isRevoked;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTimeImmutable $grantDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTimeImmutable $revokeDate;

    public function setClient(ClientInterface $client): RegisteredClient
    {
        $this->client = $client;

        return $this;
    }

    public function setUser(User $user): RegisteredClient
    {
        $this->user = $user;

        return $this;
    }

    public function setIsGranted(bool $isGranted): RegisteredClient
    {
        $this->isGranted = $isGranted;

        return $this;
    }

    public function setIsRevoked(bool $isRevoked): RegisteredClient
    {
        $this->isRevoked = $isRevoked;

        return $this;
    }

    public function setGrantDate(?DateTimeImmutable $grantDate): RegisteredClient
    {
        $this->grantDate = $grantDate;

        return $this;
    }

    public function setRevokeDate(?DateTimeImmutable $revokeDate): RegisteredClient
    {
        $this->revokeDate = $revokeDate;
        return $this;
    }

    public function setUuid(UuidInterface $uuid): RegisteredClient
    {
        $this->uuid = $uuid;
        return $this;
    }
}