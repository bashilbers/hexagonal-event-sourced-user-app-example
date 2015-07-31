<?php

namespace UserApp\Domain\User\ValueObject;

class TrialPeriod
{
    protected $from;

    protected $until;

    protected $defaultDuration = '1 month';

    protected function __construct(\DateTime $from, \DateTime $until)
    {
        $this->from = $from;
        $this->until = $until;
    }

    public static function on(\DateTime $from, \DateTime $until = null)
    {
        if (is_null($until)) {
            $until = new \DateTime('+' . $this->defaultDuration);
        }

        return new TrialPeriod($from, $until);
    }

    public static function start(\DateTime $until = null)
    {
        $now = new \DateTime('now');

        if (is_null($until)) {
            $until = new \DateTime('+' . $this->defaultDuration);
        }

        return new TrialPeriod($now, $until);
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getUntil()
    {
        return $this->until;
    }

    public function hasPassed()
    {
        return $this->until < new \DateTime('now');
    }

    public function getRemaining()
    {
        if ($this->hasPassed()) {
            return null;
        }

        return $this->until->diff(new \DateTime('now'));
    }
}