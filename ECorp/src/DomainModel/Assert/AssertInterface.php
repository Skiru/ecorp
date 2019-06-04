<?php

namespace ECorp\DomainModel\Assert;

interface AssertInterface
{
    /**
     * @param int $value
     * @param int $limit
     * @param string $message
     * @throws AssertException
     */
    public function greaterThanEq(int $value, int $limit, string $message): void;

    /**
     * @param int $value
     * @param int $limit
     * @param string $message
     * @throws AssertException
     */
    public function lessThan(int $value, int $limit, string $message): void;

    /**
     * @param string $value
     * @param string $message
     * @throws AssertException
     */
    public function stringNotEmpty(string $value, string $message): void;

    /**
     * @param string $uuid
     * @param string $message
     * @throws AssertException
     */
    public function uuid(string $uuid, string $message): void;

    /**
     * @param string $value
     * @param int $lengthMin
     * @param int $lengthMax
     * @param string $message
     * @throws AssertException
     */
    public function lengthBetween(string $value, int $lengthMin, int $lengthMax, string $message): void;
}
