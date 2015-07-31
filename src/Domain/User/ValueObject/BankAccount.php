<?php

namespace UserApp\Domain\User\ValueObject;

class BankAccount
{
    protected $holderName;

    protected $iban;

    protected $swiftbic;

    protected $signerName;

    protected $placeSigned;
}