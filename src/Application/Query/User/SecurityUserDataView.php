<?php

namespace ECorp\Application\Query\User;

class SecurityUserDataView extends UserView
{
    private string $uuid;
    private int $id;
    private string $password;
    private ?string $avatarUri;
    private array $roles;

    public function __construct(
        string $uuid,
        int $id,
        string $password,
        ?string $avatarUri,
        array $roles,
        string $email,
        string $username,
        int $age
    ) {
        parent::__construct($email, $username, $age);
        $this->uuid = $uuid;
        $this->id = $id;
        $this->password = $password;
        $this->avatarUri = $avatarUri;
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getAvatarUri(): ?string
    {
        return $this->avatarUri;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }
}