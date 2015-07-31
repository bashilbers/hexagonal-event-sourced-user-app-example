<?php

namespace UserApp\Domain\User\EventHandler;

use UserApp\Domain\User\Event\UserWasRegistered;
use UserApp\Domain\user\Entity\User;
use UserApp\Domain\User\Entity\UserRepository;
use Domain\Eventing\DomainEvent;
use Domain\Eventing\Listener;

class WhenUserWasRegistered implements Listener
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function handle(DomainEvent $event)
    {
        $entity = new User(
            (string) $event->getAggregateIdentity(),
            $event->getName(),
            $event->getEmail(),
            $event->getPasswordHash()
        );

        $this->repo->add($entity);
        $this->repo->save();
    }

    public static function handles(DomainEvent $event)
    {
        return $event instanceof UserWasRegistered;
    }
}