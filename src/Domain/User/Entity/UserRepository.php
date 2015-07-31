<?php

namespace UserApp\Domain\User\Entity;

use Symfony\Component\Security\Core\User\UserProviderInterface;

interface UserRepository extends UserProviderInterface
{
    function find($id);

    function findOneByEmail($email);

    function findOneBy(array $criteria);

    function add(User $user);
}
