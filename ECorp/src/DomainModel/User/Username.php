<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Assert\AssertException;
use ECorp\DomainModel\Assert\ECorpAssertAbstract;
use ECorp\DomainModel\BusinessRequirementsConstants;

final class Username extends ECorpAssertAbstract
{
    /**
     * @var string
     */
    private $username;

    /**
     * Username constructor.
     * @param string $username
     * @throws AssertException
     */
    public function __construct(string $username)
    {
        $this->assert->stringNotEmpty($username, 'Username cannot be empty!');
        $this->assert->lengthBetween(
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
