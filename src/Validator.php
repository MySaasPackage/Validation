<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use MySaasPackage\Validation\Rules\ChainValidator;

class Validator
{
    public static function chain(): ChainValidator
    {
        return ChainValidator::create();
    }
}
