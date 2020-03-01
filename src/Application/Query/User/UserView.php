<?php

declare(strict_types=1);

namespace ECorp\Application\Query\User;

use JsonSerializable;

class UserView implements JsonSerializable
{
    protected string $email;

    protected string $username;

    protected int $age;

    public function __construct(string $email, string $username, int $age)
    {
        $this->email = $email;
        $this->username = $username;
        $this->age = $age;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email,
            'username' => $this->username,
            'age' => $this->age
        ];
    }
}
