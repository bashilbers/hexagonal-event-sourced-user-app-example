<?php

namespace UserApp\Domain\User\ValueObject;

class Plan
{
    protected $name;

    protected $pricingMethod;

    protected $priceModifier = 1;

    protected $trialPeriod;

    protected $constraints = [];

    public function __construct($name, PricingMethod $pricingMethod, $modifier = 1, TrialPeriod $period = null, array $constraints = null)
    {
        $this->name = $name;
        $this->pricingMethod = $pricingMethod;
        $this->modifier = $modifier;
        $this->period = $period;
        $this->constraints = $constraints;
    }
}