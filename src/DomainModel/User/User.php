<?php

declare(strict_types=1);

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Uuid;

final class User implements \JsonSerializable
{
    private Uuid $uuid;

    private Email $email;

    private Username $username;

    private Age $age;

    private Password $password;

    public function __construct(Uuid $uuid, Email $email, Username $username, Age $age, Password $password)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->username = $username;
        $this->age = $age;
        $this->password = $password;
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
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
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