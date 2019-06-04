<?php

namespace ECorp\Infrastructure\Persistence\Doctrine\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use ECorp\Application\Query\User\UserQueryInterface;
use ECorp\Application\Query\User\UserView;

class DbalUserQuery implements UserQueryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * DbalUserQuery constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return int
     * @throws DBALException
     */
    public function count(): int
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('count(u.id)')
            ->from('users', 'u');

        $users = $this->connection->fetchColumn($qb->getSQL(), $qb->getParameters());
        if (!$users) return 0;

        return $users;
    }

    /**
     * @param string $uuid
     * @return UserView|null
     * @throws DBALException
     */
    public function getByUuid(string $uuid): ?UserView
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('u.username, u.email, u.age')
            ->from('users', 'u')
            ->where('u.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->setMaxResults(1);

        $user = $this->connection->fetchAssoc($qb->getSQL(), $qb->getParameters());

        if (!$user) {
            return null;
        }

        return new UserView($user['email'], $user['username'], $user['age']);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('u.username, u.age, u.email')
            ->from('users', 'u');

        $users = $this->connection->fetchAll($qb->getSQL(), $qb->getParameters());

        if (empty($users)) {
            return [];
        }

        return array_map(function(array $user) {
            return new UserView($user['email'], $user['username'], $user['age']);
        }, $users);
    }
}