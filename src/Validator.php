<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use MySaasPackage\Validation\Rules\Chained;
use MySaasPackage\Validation\Rules\CollectionOf;
use MySaasPackage\Validation\Rules\Keys;

class Validator
{
    public static function scalar(): Chained
    {
        return new Chained();
    }

    public static function collectionOf(Validatable $rule): CollectionOf
    {
        return new CollectionOf($rule);
    }

    public static function structure(): Keys
    {
        return new Keys();
    }
}
