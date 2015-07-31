<?php

namespace UserApp\Domain\User\ValueObject;

class MonthlyBasedPricingMethod implements PricingMethod
{
    protected $price;

    protected function __construct($price)
    {
        $this->price = $price;
    }

    public static function create($price)
    {
        $method = new MonthlyBasedPricingMethod($price);

        return $method;
    }

    public function getRelativeBase()
    {
        return $this->price;
    }

    public function calculate(Quote $quote)
    {
        return $quote->getFrom()->diff($quote->getTo())->m * $this->price;
    }
}