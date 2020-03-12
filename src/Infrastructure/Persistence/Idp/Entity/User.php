<?php

namespace ECorp\Infrastructure\Persistence\Idp\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="ECorp\Infrastructure\Persistence\Repository\UserDbRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @var Uuid
     *
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $uuid;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="username", type="string", nullable=false)
     */
    private $username;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private $age;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $avatarUri;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $uuid
     *
     * @return User
     */
    public function setUuid(string $uuid): User
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $this->roles;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password)
    {
        $this->password = $password;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setAge(int $age): User
    {
        $this->age = $age;
        return $this;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getAvatarUri(): ?string
    {
        return $this->avatarUri;
    }

    public function setAvatarUri(?string $avatarUri): User
    {
        $this->avatarUri = $avatarUri;
        return $this;
    }

    public static function buildFromParams(
        string $uuid,
        int $id,
        string $userName,
        string $email,
        ?string $password,
        int $age,
        ?string $avatarUri,
        array $roles = ['ROLE_USER']
    ): User {
        $user = new User();
        $user
            ->setUuid($uuid)
            ->setUsername($userName)
            ->setId($id)
            ->setEmail($email)
            ->setAge($age)
            ->setRoles($roles)
            ->setPassword($password)
            ->setAvatarUri($avatarUri);

        return $user;
    }
}
