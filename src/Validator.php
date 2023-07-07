<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use MySaasPackage\Validation\Rules\Chained;

class Validator
{
    public static function create(): Chained
    {
        return new Chained();
    }
}
