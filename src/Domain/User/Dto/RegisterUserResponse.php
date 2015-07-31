<?php

namespace UserApp\Domain\User\Dto;

class RegisterUserResponse
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
