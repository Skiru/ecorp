<?php

namespace ECorp\Application\User\Command;

use ECorp\DomainModel\User\Age;
use ECorp\DomainModel\User\Email;
use ECorp\DomainModel\User\Username;
use InvalidArgumentException;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

final class UserRegisterCommand
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
     * @throws InvalidArgumentException
     */
    public function __construct(Email $email, Username $username, Age $age, UuidInterface $uuid)
    {
        Assert::uuid($uuid, 'Generated Uuid is not correct');

        $this->uuid = $uuid->toString();
        $this->email = $email;
        $this->username = $username;
        $this->age = $age;
    }
}
