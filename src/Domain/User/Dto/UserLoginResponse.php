<?php

namespace UserApp\Domain\User\Dto;

use UserApp\Domain\User\Dto\UserView;

class UserLoginResponse
{
    public $user;

    public function __construct(UserView $user)
    {
        $this->user = $user;
    }
}
