<?php

namespace UserApp\Domain\User\Entity\Repository\Memory;

use UserApp\Domain\User\Entity\User;
use UserApp\Domain\User\Entity\UserRepository as UserRepositoryInterface;

class UserArrayRepository implements UserRepositoryInterface
{
    private $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function find($id)
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }

        return null;
    }

    public function findOneByEmail($email)
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }

        return null;
    }

    public function add(User $user)
    {
        if (null !== $this->find($user->getId())) {
            throw new \InvalidArgumentException('User already exists');
        }

        $this->users[] = $user;
    }
}
