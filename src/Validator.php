<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use MySaasPackage\Validation\Rules\ArrayStructure;
use MySaasPackage\Validation\Rules\Chained;
use MySaasPackage\Validation\Rules\ObjectStructure;

class Validator
{
    public static function chain(): Chained
    {
        return new Chained();
    }

    public static function arrayStructure(): ArrayStructure
    {
        return new ArrayStructure();
    }

    public static function objectStructure(): ObjectStructure
    {
        return new ObjectStructure();
    }
}
