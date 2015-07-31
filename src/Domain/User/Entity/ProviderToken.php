<?php

namespace UserApp\Domain\User\Entity;

class ProviderToken
{
    protected $provider;

    protected $uid;

    protected $token;

    protected $endOfLife;

    protected $addedOn;

    public function __construct($provider, $uid, $token, $endOfLife, $addedOn)
    {
        $this->provider = $provider;
        $this->uid = $uid;
        $this->token = $token;
        $this->endOfLife = $endOfLife;
        $this->addedOn = $addedOn;
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getEndOfLife()
    {
        return $this->endOfLife;
    }

    public function addedOn()
    {
        return $this->addedOn;
    }
}