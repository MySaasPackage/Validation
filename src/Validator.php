<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use MySaasPackage\Validation\Rules\ArrayStruct;
use MySaasPackage\Validation\Rules\Chained;
use MySaasPackage\Validation\Rules\CollectionOf;
use MySaasPackage\Validation\Rules\ObjectStruct;

class Validator
{
    public static function chain(): Chained
    {
        return new Chained();
    }

    public static function collectionOf(Validatable $rule): CollectionOf
    {
        return new CollectionOf($rule);
    }

    public static function arrayStruct(): ArrayStruct
    {
        return new ArrayStruct();
    }

    public static function objectStruct(): ObjectStruct
    {
        return new ObjectStruct();
    }
}
