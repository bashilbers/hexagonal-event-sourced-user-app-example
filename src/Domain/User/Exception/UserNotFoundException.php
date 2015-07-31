<?php

namespace UserApp\Domain\User\Exception;

use UserApp\Domain\Exception as BaseException;

class UserNotFoundException extends \Exception implements BaseException
{
    public $email;

    public function __construct($email)
    {
        parent::__construct();

        $this->email = $email;
    }
}
