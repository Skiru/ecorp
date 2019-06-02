<?php

namespace ECorp\DomainModel\User;

use ECorp\DomainModel\BusinessRequirementsConstants;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

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
     * @throws InvalidArgumentException
     */
    public function __construct(int $age)
    {
        Assert::greaterThanEq(
            $age,
            BusinessRequirementsConstants::MINIMAL_USER_AGE,
            sprintf('Age can not be less than %s', BusinessRequirementsConstants::MINIMAL_USER_AGE)
        );
        Assert::lessThan($age, self::STUPID_USER_AGE_INPUT, 'Are you sure about the age???');

        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }
}
