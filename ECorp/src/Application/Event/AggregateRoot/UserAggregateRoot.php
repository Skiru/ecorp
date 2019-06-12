<?php

namespace ECorp\Application\Event\AggregateRoot;

use ECorp\DomainModel\User\Event\UnknownDomainEventType;
use ECorp\DomainModel\User\Event\UserRegistered;
use ECorp\DomainModel\User\User;
use ECorp\DomainModel\Uuid;
use Exception;

final class UserAggregateRoot implements AggregateRootInterface
{
    /**
     * @var Uuid
     */
    private $userAggregateRootUuid;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var int
     */
    private $age;

    /**
     * @var object[]
     */
    private $events = [];

    /**
     * UserAggregateRoot constructor.
     * @param Uuid $userAggregateRootUuid
     */
    public function __construct(Uuid $userAggregateRootUuid)
    {
        $this->userAggregateRootUuid = $userAggregateRootUuid;
    }

    /**
     * @return Uuid
     */
    public function getAggregateRootUuid(): Uuid
    {
        return $this->userAggregateRootUuid;
    }

    /**
     * @param User $user
     * @throws UnknownDomainEventType
     * @throws Exception
     */
    public function registerUser(User $user): void
    {
        //Additional validation can be done here
        $this->record(new UserRegistered($this->userAggregateRootUuid, $user));
    }

    /**
     * @param $event
     * @throws UnknownDomainEventType
     */
    private function record($event): void
    {
        $this->events[] = $event;
        $this->apply($event);
    }

    /**
     * @param object $event
     * @throws UnknownDomainEventType
     */
    private function apply(object $event): void
    {
        switch (get_class($event)) {
            case UserRegistered::class:
                /** @var UserRegistered $event uuid */
                $this->userAggregateRootUuid = $event->getUserAggregateRootUuid();
                $this->email = $event->getUser()->getEmail()->getEmail();
                $this->age = $event->getUser()->getAge()->getAge();
                $this->username = $event->getUser()->getUsername()->getUsername();
                break;

            default:
                throw new UnknownDomainEventType(sprintf(
                   'Unknown event type %s',
                   get_class($event)
                ));
        }
    }

    /**
     * @return object[]
     */
    public function releaseEvents(): array
    {
        $releasedEvents = $this->events;
        $this->events = [];

        return $releasedEvents;
    }

    /**
     * @param Uuid $aggregateRootUuid
     * @param array $events
     * @return AggregateRootInterface
     * @throws UnknownDomainEventType
     */
    public function reconstituteFromEvents(Uuid $aggregateRootUuid, array $events): AggregateRootInterface
    {
        $aggregateRoot = new UserAggregateRoot($aggregateRootUuid);

        foreach ($events as $event) {
            $aggregateRoot->apply($event);
        }

        return $aggregateRoot;
    }
}
