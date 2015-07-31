<?php

namespace UserApp\Domain\User\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface as SecurityUser;

class User implements SecurityUser
{
    protected $id;
    protected $name;
    protected $firstName;
    protected $lastname;
    protected $city;
    protected $birthDate;
    protected $gender;
    protected $roles = [];
    protected $salt;
    protected $username;
    protected $password;
    protected $email;
    protected $enabled;
    protected $accountNonExpired;
    protected $credentialsNonExpired;
    protected $accountNonLocked;
    protected $providerTokens = [];
    protected $plan;

    public function __construct($id, $name, $email, $passwordHash, $providerTokens, array $roles = array(), $enabled = true, $userNonExpired = true, $credentialsNonExpired = true, $userNonLocked = true)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $passwordHash;
        $this->providerTokens = $providerTokens;
        $this->enabled = $enabled;
        $this->accountNonExpired = $userNonExpired;
        $this->credentialsNonExpired = $credentialsNonExpired;
        $this->accountNonLocked = $userNonLocked;
        $this->roles = $roles;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        return $this->accountNonExpired;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return $this->accountNonLocked;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        return $this->credentialsNonExpired;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {

    }

    public function getProviderToken($provider)
    {
        foreach ($this->providerTokens as $token) {
            if ($token->getProvider() === $provider) {
                return $token;
            }
        }

        return null;
    }

    public function getProviderTokens()
    {
        return $this->providerTokens;
    }

    public function getPlan()
    {
        return $this->plan;
    }
}
