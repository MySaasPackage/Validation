<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleResult;
use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class IsString implements Validatable
{
    public const KEYWORD = 'string.mismatch';

    public function validate(mixed $value): RuleResult
    {
        if (is_string($value)) {
            return RuleResult::succeeded();
        }

        return RuleResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                message: 'The provided value is not a string'
            )
        );
    }
}
