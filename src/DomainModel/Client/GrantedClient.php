<?php

declare(strict_types=1);

namespace App\DomainModel\Client;

use DateTimeImmutable;
use ECorp\DomainModel\Uuid;

final class GrantedClient
{
    private Uuid $uuid;
    private Uuid $clientUuid;
    private Uuid $userUuid;
    private bool $isGranted;
    private bool $isRevoked;
    private DateTimeImmutable $grantDate;
    private DateTimeImmutable $revokeDate;

    public function __construct(
        Uuid $uuid,
        Uuid $clientUuid,
        Uuid $userUuid,
        bool $isGranted,
        bool $isRevoked,
        DateTimeImmutable $grantDate,
        DateTimeImmutable $revokeDate
    ) {
        $this->uuid = $uuid;
        $this->clientUuid = $clientUuid;
        $this->userUuid = $userUuid;
        $this->isGranted = $isGranted;
        $this->isRevoked = $isRevoked;
        $this->grantDate = $grantDate;
        $this->revokeDate = $revokeDate;
    }
}
