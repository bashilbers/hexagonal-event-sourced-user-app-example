<?php

namespace UserApp\Domain\User\Identity;

use Domain\Identity\Identity;
use Domain\Identity\Generator;

class UserId implements Identity, Generator
{
    private $userId;

    /**
     * @param string $userId
     */
    public function __construct($userId)
    {
        $this->userId = (string) $userId;
    }

    public static function fromString($string)
    {
        return new UserId($string);
    }

    public function __toString()
    {
        return $this->userId;
    }

    public function equals(Identity $other)
    {
        return
            $other instanceof UserId
            && (string) $this == (string) $other;
    }

    public static function generate()
    {
        $badSampleUuid = md5(uniqid());
        return new UserId($badSampleUuid);
    }
}