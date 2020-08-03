<?php

declare(strict_types=1);

namespace ECorp\Application\Client\Query;

use DateTimeImmutable;
use ECorp\DomainModel\Uuid;

class GrantedClientView
{
    private Uuid $uuid;
    private bool $isGranted;
    private bool $isRevoked;
    private ?DateTimeImmutable $grantDate;
    private ?DateTimeImmutable $revokeDate;

    private function __construct(
        Uuid $uuid,
        bool $isGranted,
        bool $isRevoked,
        ?DateTimeImmutable $grantDate,
        ?DateTimeImmutable $revokeDate
    ) {
        $this->uuid = $uuid;
        $this->isGranted = $isGranted;
        $this->isRevoked = $isRevoked;
        $this->grantDate = $grantDate;
        $this->revokeDate = $revokeDate;
    }

    public static function fromArray(array $data): GrantedClientView
    {
        return new GrantedClientView(
            new Uuid($data['uuid']),
            $data['is_granted'],
            $data['is_revoked'],
            null !== $data['grant_date'] ? new DateTimeImmutable($data['grant_date']) : null,
            null !== $data['revoke_date'] ? new DateTimeImmutable($data['revoke_date']) : null,
        );
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function isGranted(): bool
    {
        return $this->isGranted;
    }

    public function isRevoked(): bool
    {
        return $this->isRevoked;
    }

    public function getGrantDate(): ?DateTimeImmutable
    {
        return $this->grantDate;
    }

    public function getRevokeDate(): ?DateTimeImmutable
    {
        return $this->revokeDate;
    }
}