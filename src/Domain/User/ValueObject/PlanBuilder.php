<?php

namespace UserApp\Domain\User\ValueObject;

class PlanBuilder
{
    protected $name;

    protected $pricingMethod;

    protected $trialPeriod;

    protected $pricingModifier = 1;

    protected $constraints = [];

    protected function __construct($name)
    {
        $this->name = $name;
        $this->pricingMethod = new MonthlyBasedPricingMethod(275);
        $this->trialPeriod = TrialPeriod::start();
    }

    public static function create($name = null)
    {
        if (is_null($name)) {
            $name = 'anonymous custom plan';
        }

        return new PlanBuilder($name);
    }

    public function setPricingMethod(PricingMethod $method)
    {
        $this->pricingMethod = $method;

        return $this;
    }

    public function setTrialPerdiod(TrialPeriod $period)
    {
        $this->trialPeriod = $period;

        return $this;
    }

    public function setPriceModifier($modifier)
    {
        $this->pricingModifier = $modifier;

        return $this;
    }

    public function addConstraint($constraint)
    {
        $this->constraints[] = $constraint;

        return $this;
    }

    public function getPlan()
    {
        return new Plan(
            $this->name,
            $this->pricingMethod,
            $this->trialPeriod,
            $this->priceModifier,
            $this->constraints
        );
    }
}