<?php

namespace UserApp\Domain\User\Service;

interface PasswordEncoder
{
    function encodePassword($password);

    function isPasswordValid($encoded, $raw);
}
