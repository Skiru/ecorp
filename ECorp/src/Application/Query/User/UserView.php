<?php

namespace ECorp\Application\Query\User;

final class UserView implements \JsonSerializable
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var int
     */
    private $age;

    /**
     * UserView constructor.
     * @param string $email
     * @param string $username
     * @param int $age
     */
    public function __construct(string $email, string $username, int $age)
    {
        $this->email = $email;
        $this->username = $username;
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email,
            'username' => $this->username,
            'age' => $this->age
        ];
    }
}
