<?php

namespace ECorp\DomainModel\User\Event;

use DateTime;
use ECorp\DomainModel\User\User;
use ECorp\DomainModel\Uuid;
use Exception;

final class UserRegistered implements \JsonSerializable
{
    /**
     * @var Uuid
     */
    private $userAggregateRootUuid;

    /**
     * @var User
     */
    private $user;

    /**
     * zobacz przy persiste'owaniu
     * @var DateTime
     */
    private $ocuranceDate;

    /**
     * UserRegistered constructor.
     * @param Uuid $userAggregateRootUuid
     * @param User $user
     * @throws Exception
     */
    public function __construct(Uuid $userAggregateRootUuid, User $user)
    {
        $this->userAggregateRootUuid = $userAggregateRootUuid;
        $this->user = $user;
        $this->ocuranceDate = new DateTime();
    }

    /**
     * @return Uuid
     */
    public function getUserAggregateRootUuid(): Uuid
    {
        return $this->userAggregateRootUuid;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'event_name' => 'UserRegistered',
            'user' => $this->user,
            'occurance_date' => $this->ocuranceDate->format(DATE_ISO8601)
        ];
    }
}
