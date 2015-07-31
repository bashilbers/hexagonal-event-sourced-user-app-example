<?php

namespace UserApp\Domain\User\ValueObject;

interface PricingMethod
{
    public function getRelativeBase();

    public function calculate(Quote $quote);
}