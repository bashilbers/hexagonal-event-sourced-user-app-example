<?php

namespace UserApp\Domain\User\Event;

use UserApp\Domain\User\Identity\UserId;
use Domain\Eventing\DomainEvent;
use ValueObjects\Person\Name;
use ValueObjects\Web\EmailAddress;

final class UserWasRegistered implements DomainEvent
{
    private $userId;
    private $name;
    private $email;
    private $passwordHash;

    public function __construct(UserId $userId, Name $name, EmailAddress $email, $passwordHash)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public function getAggregateIdentity()
    {
        return $this->userId;
    }

    public function getVersion()
    {
        return 0;
    }

    public function getCreationDate()
    {
        return new \DateTime();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }
}