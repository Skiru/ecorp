<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Assert\DomainUserModelException;
use ECorp\Infrastructure\Assert\EcorpAssert;
use Ramsey\Uuid\UuidInterface;

final class User
{
    /**
     * @var UuidInterface
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
     * @param UuidInterface $uuid
     * @throws DomainUserModelException
     */
    public function __construct(Email $email, Username $username, Age $age, UuidInterface $uuid)
    {
        EcorpAssert::uuid($uuid, 'Generated Uuid is not correct');

        $this->uuid = $uuid->toString();
        $this->email = $email;
        $this->username = $username;
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getUuid(): string
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
}