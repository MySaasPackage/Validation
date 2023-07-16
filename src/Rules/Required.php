<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;
use MySaasPackage\Validation\Violation;

class Required implements Validatable
{
    public const KEYWORD = 'value.required';

    public function validate(mixed $value = null): ValidatableResult
    {
        if (null !== $value) {
            return ValidatableResult::succeeded();
        }

        return ValidatableResult::failed(
            new Violation(
                self::KEYWORD,
                args: $value,
                message: 'The value is required'
            )
        );
    }
}
