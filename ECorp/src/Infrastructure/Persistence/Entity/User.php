<?php

namespace ECorp\Infrastructure\Persistence\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @ORM\Entity(repositoryClass="ECorp\Infrastructure\Persistence\Repository\UserDbRepository")
 */
class User
{
    /**
     * @var int
     * @ORM\Column(name="id")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="uuid", type="string", nullable=false)
     */
    private $uuid;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", nullable=false)
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", nullable=false)
     */
    private $email;

    /**
     * @var int
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private $age;

    /**
     * @param string $uuid
     * @return User
     */
    public function setUuid(string $uuid): User
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param int $age
     * @return User
     */
    public function setAge(int $age): User
    {
        $this->age = $age;
        return $this;
    }
}
