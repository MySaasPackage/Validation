<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use MySaasPackage\Validation\Rules\ValidatableChain;

class Validator
{
    public static function create(): ValidatableChain
    {
        return new ValidatableChain();
    }
}
