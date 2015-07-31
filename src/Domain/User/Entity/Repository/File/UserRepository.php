<?php

namespace UserApp\Domain\User\Entity\Repository\File;

use UserApp\Domain\User\Entity\User;
use UserApp\Domain\User\Entity\ProviderToken;
use UserApp\Domain\User\Entity\UserRepository as UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $file;

    private $users = [];

    public function __construct($file)
    {
        $this->file = $file;
        $this->users = $this->loadUsers();
    }

    public function find($id)
    {
        return $this->findOneByField('id', $id);
    }

    public function findOneByEmail($email)
    {
        return $this->findOneByField('email', $email);
    }

    public function add(User $user)
    {
        $this->users[] = $user;
    }

    public function save()
    {
        $rawUsers = $this->serializeUsers();
        $json = json_encode($rawUsers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->file, $json."\n");
    }

    private function findOneByField($field, $value)
    {
        foreach ($this->users as $user) {
            $getter = 'get'.$field;
            if ($value === $user->$getter()) {
                return $user;
            }
        }

        return null;
    }

    private function loadUsers()
    {
        if (!file_exists($this->file)) {
            return [];
        }

        $rawUsers = json_decode(file_get_contents($this->file), true) ?: [];

        return array_map(
            function ($rawUser) {
                $tokens = array_map(
                    function ($token) {
                        return new ProviderToken(
                            $token['provider'],
                            $token['uid'],
                            unserialize($token['token']),
                            $token['endOfLife'],
                            $token['addedOn']
                        );
                    },
                    $rawUser['providerTokens']
                );

                return new User(
                    $rawUser['id'],
                    $rawUser['name'],
                    $rawUser['email'],
                    $rawUser['passwordHash'],
                    $tokens,
                    $rawUser['roles']
                );
            },
            $rawUsers
        );
    }

    private function serializeUsers()
    {
        return array_map(
            function ($user) {
                return [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'passwordHash' => $user->getPasswordHash(),
                ];
            },
            $this->users
        );
    }

    public function loadUserByOAuthCredentials(\Gigablah\Silex\OAuth\Security\Authentication\Token\OAuthTokenInterface $token)
    {
        foreach ($this->users as $user) {
            $providerToken = $user->getProviderToken($token->getService());
            if (!is_null($providerToken) && $providerToken->getUid() == $token->getUid()) {
                return $user;
            }
        }

        return null;
    }

    public function loadUserByUsername($username)
    {
        return $this->findOneByField('username', $username);
    }

    public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user)
    {
        return $user;
    }

    public function supportsClass($class)
    {
        return $class === User::class;
    }

    public function findOneBy(array $criteria)
    {
        foreach ($this->users as $user) {
            foreach ($criteria as $field => $value) {
                $getter = 'get' . ucfirst($field);
                if ($user->$getter() !== $value) {
                    continue 2;
                }
            }

            return $user;
        }

        return null;
    }
}
