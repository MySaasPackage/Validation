<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;
use MySaasPackage\Validation\Violation;

class IsCollection implements Validatable
{
    public const KEYWORD = 'collection.mismatch';

    public function validate(mixed $value): ValidatableResult
    {
        if (is_array($value)) {
            return ValidatableResult::succeeded();
        }

        return ValidatableResult::failed(new Violation(
            self::KEYWORD,
            'The provided value is not a collection'
        ));
    }
}
