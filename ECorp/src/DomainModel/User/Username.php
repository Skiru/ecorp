<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Assert\DomainUserModelException;
use ECorp\DomainModel\BusinessRequirementsConstants;
use ECorp\Infrastructure\Assert\EcorpAssert;

final class Username
{

    /**
     * @var string
     */
    private $username;

    /**
     * Username constructor.
     * @param string $username
     * @throws DomainUserModelException
     */
    public function __construct(string $username)
    {
        EcorpAssert::stringNotEmpty($username, 'Username cannot be empty!');
        EcorpAssert::lengthBetween(
            $username,
            BusinessRequirementsConstants::MIN_USERNAME_LENGTH,
            BusinessRequirementsConstants::MAX_USERNAME_LENGTH,
            sprintf(
                'Username length must be between %s - %s',
                BusinessRequirementsConstants::MIN_USERNAME_LENGTH,
                BusinessRequirementsConstants::MAX_USERNAME_LENGTH
            )
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
