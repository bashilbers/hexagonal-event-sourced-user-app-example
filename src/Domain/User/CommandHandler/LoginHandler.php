<?php

namespace UserApp\Domain\User\CommandHandler;

use UserApp\Domain\User\Dto\UserLoginResponse;
use UserApp\Domain\User\Dto\UserView;
use UserApp\Domain\User\Command\Login;
use UserApp\Domain\User\Services\PasswordEncoder;
use UserApp\Domain\User\Entity\UserRepository;
use UserApp\Domain\User\Exception\IncorrectPasswordException;
use UserApp\Domain\User\Exception\UserNotFoundException;

class LoginHandler
{
    private $userRepo;
    private $passwordEncoder;

    public function __construct(UserRepository $userRepo, PasswordEncoder $passwordEncoder)
    {
        $this->userRepo = $userRepo;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(Login $request)
    {
        $user = $this->userRepo->findOneByEmail($request->email);

        if (!$user) {
            throw new UserNotFoundException($request->email);
        }

        if (!$this->passwordEncoder->isPasswordValid($user->getPasswordHash(), $request->password)) {
            throw new IncorrectPasswordException($request->email);
        }

        return new UserLoginResponse(UserView::fromUser($user));
    }
}
