<?php

namespace ECorp\Infrastructure\Assert;

use ECorp\DomainModel\Assert\AssertInterface;
use ECorp\DomainModel\Assert\AssertException;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

class EcorpAssert implements AssertInterface
{
    /**
     * {@inheritDoc}
     */
    public function greaterThanEq(int $value, int $limit, string $message): void
    {
        try {
            Assert::greaterThanEq($value, $limit, $message);
        } catch (InvalidArgumentException $argumentException) {
            throw new AssertException($argumentException->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function lessThan(int $value, int $limit, string $message): void
    {
        try {
            Assert::lessThan($value, $limit, $message);
        } catch (InvalidArgumentException $argumentException) {
            throw new AssertException($argumentException->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function stringNotEmpty(string $value, string $message): void
    {
        try {
            Assert::stringNotEmpty($value, $message);
        } catch (InvalidArgumentException $argumentException) {
            throw new AssertException($argumentException->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function uuid(string $uuid, string $message): void
    {
        try {
            Assert::uuid($uuid, $message);
        } catch (InvalidArgumentException $argumentException) {
            throw new AssertException($argumentException->getMessage());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function lengthBetween(string $value, int $lengthMin, int $lengthMax, string $message): void
    {
        Assert::lengthBetween(
            $value,
            $lengthMin,
            $lengthMax,
            $message
        );
    }
}
