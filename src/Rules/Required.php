<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\SimpleViolation;

class Required implements Validatable
{
    public const KEYWORD = 'value.required';

    public function validate(mixed $value = null): Violation|null
    {
        if (null !== $value) {
            return null;
        }

        return new SimpleViolation(
            self::KEYWORD,
            message: 'The provided value is required'
        );
    }
}
