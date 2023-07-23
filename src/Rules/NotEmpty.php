<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\SimpleViolation;

use function count;
use function is_array;
use function is_string;
use function strlen;

class NotEmpty implements Validatable
{
    public const KEYWORD = 'value.empty';

    public function validate(mixed $value): Violation|null
    {
        if ((is_array($value) && count($value) > 0)
            || (is_string($value) && strlen($value) > 0)) {
            return null;
        }

        return new SimpleViolation(
            keyword: self::KEYWORD,
            message: 'The provided value cannot be empty'
        );
    }
}
