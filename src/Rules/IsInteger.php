<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\SimpleViolation;

class IsInteger implements Validatable
{
    public const KEYWORD = 'integer.mismatch';

    public function validate(mixed $value): Violation|null
    {
        if (is_int($value)) {
            return null;
        }

        return new SimpleViolation(
            keyword: self::KEYWORD,
            message: 'The provided value must be an integer',
        );
    }
}
