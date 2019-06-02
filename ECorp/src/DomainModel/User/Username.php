<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\BusinessRequirementsConstants;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

final class Username
{

    /**
     * @var string
     */
    private $username;

    /**
     * Username constructor.
     * @param string $username
     * @throws InvalidArgumentException
     */
    public function __construct(string $username)
    {
        Assert::stringNotEmpty($username, 'Username cannot be empty!');
        Assert::lengthBetween(
            $username,
            BusinessRequirementsConstants::MIN_USERNAME_LENGTH,
            BusinessRequirementsConstants::MAX_USERNAME_LENGTH
        );

        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}
