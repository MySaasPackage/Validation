<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleResult;
use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class Required implements Validatable
{
    public const KEYWORD = 'value.required';

    public function validate(mixed $value = null): RuleResult
    {
        if (null !== $value) {
            return RuleResult::succeeded();
        }

        return RuleResult::failed(
            new Violation(
                self::KEYWORD,
                message: 'The value is required'
            )
        );
    }
}
