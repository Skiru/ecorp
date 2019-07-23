<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\Assert\AssertException;
use ECorp\DomainModel\Assert\ECorpAssert;
use ECorp\DomainModel\BusinessRequirementsConstants;

final class Age
{
    const STUPID_USER_AGE_INPUT = 150;

    /**
     * @var int
     */
    private $age;

    /**
     * Age constructor.
     * @param int $age
     * @throws AssertException
     */
    public function __construct(int $age)
    {
        ECorpAssert::greaterThanEq(
            $age,
            BusinessRequirementsConstants::MINIMAL_USER_AGE,
            sprintf('Age can not be less than %s', BusinessRequirementsConstants::MINIMAL_USER_AGE)
        );
        ECorpAssert::lessThan($age, self::STUPID_USER_AGE_INPUT, 'Are you sure about the age???');

        $this->age = $age;
    }

    /**
     * @return int
     */
    public function asInt(): int
    {
        return $this->age;
    }
}
