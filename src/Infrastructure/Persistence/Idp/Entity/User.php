<?php

namespace ECorp\Infrastructure\Persistence\Idp\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="ECorp\Infrastructure\Persistence\Repository\UserDbRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(name="id")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     */
    private $id;

    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $uuid;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", nullable=false)
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @var int
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private $age;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $avatarUri;

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return [
            'ROLE_USER'
        ];
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        //bcrypt handles salt on its own
        return null;
    }

    public function eraseCredentials(): void
    {
        $this->password = null;
    }
}
