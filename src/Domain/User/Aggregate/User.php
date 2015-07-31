<?php

namespace UserApp\Domain\User\Aggregate;

use UserApp\Domain\User\Identity\UserId;
use UserApp\Domain\User\Event\UserWasEnabled;
use UserApp\Domain\User\Event\UserWasDisabled;
use UserApp\Domain\User\Event\UserWasRegistered;
use UserApp\Domain\User\ValueObject\Plan;
use Domain\Aggregates\BaseAggregateRoot;
use ValueObjects\Person\Name;
use ValueObjects\Web\EmailAddress;

final class User extends BaseAggregateRoot
{
    private $enabled;

    private $groups = [];

    public static function register(UserId $userId, Name $name, EmailAddress $email, $password)
    {
        $user = new User($userId);

        $user->recordThat(
            new UserWasRegistered($userId, $name, $email, $password)
        );

        return $user;
    }

    public function setCompany()
    {

    }

    public function setBilling(Billing $billing)
    {
        
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function enable()
    {
        if ($this->enabled) {
            return;
        }

        $this->enabled = true;

        $this->recordThat(
            new UserWasEnabled($this->getIdentity())
        );

        return $this;
    }

    public function disable()
    {
        if (!$this->enabled) {
            return;
        }

        $this->enabled = false;

        $this->recordThat(
            new UserWasDisabled($this->getIdentity())
        );

        return $this;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function addedToGroup(Group $group)
    {
        foreach($this->groups as $existingGroup) {
            if ($group->name === $existingGroup->name) {
                return;
            }
        }

        $this->groups[] = $existingGroup;

        $this->recordThat(
            new UserWasAddedToGroup($this->getIdentity(), $group)
        );

        return $this;
    }

    public function removedFromGroup(Group $group)
    {
        $found = false;

        foreach($this->groups as $existingGroup) {
            if ($group->name === $existingGroup->name) {
                unset($this->groups[key($this->groups)]);
                $found = true;
            }
        }

        if (!$found) {
            return;
        }

        $this->recordThat(
            new UserWasRemovedFromGroup($this->getIdentity(), $group)
        );

        return $this;
    }

    public function changePlan(Plan $plan)
    {
        $this->recordThat(
            new UserPlanWasChanged($this->getIdentity, $plan)
        );

        return $this;
    }
}