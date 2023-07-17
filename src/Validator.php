<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class Validator
{
    public static function create(): ValidatableChain
    {
        return ValidatableChain::create();
    }
}
