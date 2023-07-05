<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\ViolationsResult;

class Required implements Validatable
{
    public const KEYWORD = 'value.required';

    public function validate(mixed $value = null): ViolationsResult
    {
        if (null !== $value) {
            return ViolationsResult::succeeded();
        }

        return ViolationsResult::failed(
            new Violation(
                self::KEYWORD,
                args: $value,
                message: 'The value is required'
            )
        );
    }
}
