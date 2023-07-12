<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use MySaasPackage\Validation\Rules\Expect;

class Validator
{
    public static function create(): Expect
    {
        return new Expect();
    }
}
