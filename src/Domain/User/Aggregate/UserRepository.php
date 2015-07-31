<?php

namespace UserApp\Domain\User\Aggregate;

use Domain\Aggregates\BaseAggregateRepository;

final class UserRepository extends BaseAggregateRepository
{
    protected function getAggregateRootFqcn()
    {
        return 'UserApp\Domain\User\Aggregate\User';
    }
}