<?php

namespace ECorp\DomainModel\Assert;

abstract class ECorpAssertAbstract
{
    /**
     * @var AssertInterface
     */
    protected $assert;

    /**
     * @param AssertInterface $assert
     */
    public function setAssert(AssertInterface $assert): void
    {
        $this->assert = $assert;
    }
}
