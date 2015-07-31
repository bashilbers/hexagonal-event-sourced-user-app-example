<?php

namespace UserApp\Domain\User\CommandHandler;

use UserApp\Domain\User\Command\Register;
use UserApp\Domain\User\Dto\RegisterUserResponse;
use UserApp\Domain\User\Identity\UserId;
use UserApp\Domain\User\ValueObject\PlanBuilder;
use UserApp\Domain\User\ValueObject\MonthlyBasedPricingMethod;
use UserApp\Domain\User\ValueObject\TrialPeriod;
use UserApp\Domain\User\Aggregate\User;
use UserApp\Domain\User\Aggregate\UserRepository;
use UserApp\Domain\User\Service\PasswordEncoder;
use ValueObjects\Person\Name;
use ValueObjects\Web\EmailAddress;

class RegisterHandler
{
    private $userRepo;

    public function __construct(UserRepository $userRepo, PasswordEncoder $passwordEncoder)
    {
        $this->userRepo = $userRepo;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(Register $request)
    {
        $passwordHash = $this->passwordEncoder->encodePassword($request->password);

        if (empty($request->id)) {
            $id = UserId::fromString($request->email);
        } else {
            $id = $request->id;
        }

        $plan = PlanBuilder::create()
            ->setPricingMethod(MonthlyBasedPricingMethod::create(275))
            ->setTrialPerdiod(TrialPeriod::start())
            ->getPlan();

        var_dump($plan);
        exit;

        $user = User::register(
            $id,
            new Name($request->firstName, $request->middleName, $request->lastName),
            new EmailAddress($request->email),
            $passwordHash, $plan
        );

        $this->userRepo->save($user);

        return new RegisterUserResponse($id);
    }
}
