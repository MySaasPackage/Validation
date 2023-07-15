<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;
use MySaasPackage\Validation\Violation;

class IsString implements Validatable
{
    public const KEYWORD = 'string.mismatch';

    public function validate(mixed $value): ValidatableResult
    {
        if (is_string($value)) {
            return ValidatableResult::succeeded();
        }

        return ValidatableResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: 'The provided value is not a string'
            )
        );
    }
}
