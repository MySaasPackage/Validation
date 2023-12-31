<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\SimpleViolation;

use function is_null;

class NotNull implements Validatable
{
    public const KEYWORD = 'value.null';

    public function validate(mixed $value = null): Violation|null
    {
        if (!is_null($value)) {
            return null;
        }

        return new SimpleViolation(
            keyword: self::KEYWORD,
            message: 'The provided value cannot be null'
        );
    }
}
