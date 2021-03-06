<?php

namespace ECorp\Infrastructure\Persistence\Doctrine\Dbal;

use Doctrine\DBAL\DBALException;
use ECorp\Application\User\Query\SecurityUserDataView;
use ECorp\Application\User\Query\UserQueryInterface;
use ECorp\Application\User\Query\UserView;
use ECorp\Infrastructure\Persistence\Doctrine\AbstractQuery;

class DbalUserQuery extends AbstractQuery implements UserQueryInterface
{
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

    /**
     * @param string $email
     * @return UserView|null
     * @throws DBALException
     */
    public function getByEmail(string $email): ?UserView
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('u.username, u.age, u.email')
            ->from('users', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->setMaxResults(1);

        $user = $this->connection->fetchAssoc($qb->getSQL(), $qb->getParameters());

        if (!$user) {
            return null;
        }

        return new UserView($user['email'], $user['username'], $user['age']);
    }

    /**
     * @param string $email
     * @return SecurityUserDataView|null
     * @throws DBALException
     */
    public function getAllByEmail(string $email): ?SecurityUserDataView
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('*')
            ->from('users', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->setMaxResults(1);

        $user = $this->connection->fetchAssoc($qb->getSQL(), $qb->getParameters());

        if (!$user) {
            return null;
        }

        return new SecurityUserDataView(
            $user['uuid'],
            $user['id'],
            $user['password'],
            $user['avatar_uri'],
            unserialize($user['roles']),
            $user['email'],
            $user['username'],
            $user['age'],
        );
    }
}
