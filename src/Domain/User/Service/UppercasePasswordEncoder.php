<?php

namespace UserApp\Domain\User\Service;

class UppercasePasswordEncoder implements PasswordEncoder
{
    public function encodePassword($password)
    {
        return strtoupper($password);
    }

    public function isPasswordValid($encoded, $raw)
    {
        return $encoded === $this->encodePassword($raw);
    }
}
