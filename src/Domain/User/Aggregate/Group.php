<?php

namespace UserApp\Domain\User\Aggregate;

class Group
{
    private $roles = [];

    public static function assemble(GroupId $id, $name, $roles)
    {
        $group = new Group($id);

        $group->recordThat(
            new GroupWasAssembled($id, $name)
        );

        if (!is_array($roles)) {
            $roles = (array) $roles;
        }

        foreach ($roles as $role) {
            $group->addRole($role);
        }

        return $group;
    }

    public function changeName($name)
    {
        $this->recordThat(
            new GroupNameWasChanged($this->getIdentity(), $name)
        );

        return $this;
    }

    public function addRole($role)
    {
        if ($this>hasRole($role)) {
            return;
        }

        $this->recordThat(
            new RoleWasAddedToGroup($this->getIdentity(), $role)
        );

        $this->roles[] = $role;

        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->roles, true);
    }

    public function removeRole($role)
    {
        $key = array_search(strtoupper($role), $this->roles, true);

        if ($key === false) {
            return;
        }

        $this->recordThat(
            new RoleWasRemovedFromGroup($this->getIdentity(), $role)
        );

        unset($this->roles[$key]);
        $this->roles = array_values($this->roles);

        return $this;
    }
}