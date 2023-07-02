<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleValidationResult;
use MySaasPackage\Validation\Violation;

class Required
{
    public const KEYWORD = 'value.required';

    public function validate(mixed $value = null): RuleValidationResult
    {
        if (null !== $value) {
            return RuleValidationResult::ok();
        }

        return RuleValidationResult::failed(
            new Violation(
                self::KEYWORD,
                args: $value,
                message: 'The value is required'
            )
        );
    }
}
