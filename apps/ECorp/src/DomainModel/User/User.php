<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Uuid;

final class User implements \JsonSerializable
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var Username
     */
    private $username;

    /**
     * @var Age
     */
    private $age;

    /**
     * UserRegisterCommand constructor.
     * @param Email $email
     * @param Username $username
     * @param Age $age
     * @param Uuid $uuid
     */
    public function __construct(Email $email, Username $username, Age $age, Uuid $uuid)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->username = $username;
        $this->age = $age;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Username
     */
    public function getUsername(): Username
    {
        return $this->username;
    }

    /**
     * @return Age
     */
    public function getAge(): Age
    {
        return $this->age;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'username' => $this->username->asString(),
            'age' => $this->age->asInt(),
            'email' => $this->email->asString(),
            'uuid' => $this->uuid->asString()
        ];
    }
}