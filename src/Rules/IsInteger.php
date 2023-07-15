<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;
use MySaasPackage\Validation\Violation;

class IsInteger implements Validatable
{
    public const KEYWORD = 'integer.mismatch';

    public function validate(mixed $value): ValidatableResult
    {
        if (is_int($value)) {
            return ValidatableResult::succeeded();
        }

        return ValidatableResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: 'The provided value is not an integer',
            )
        );
    }
}
