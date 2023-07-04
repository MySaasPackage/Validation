<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Rule;
use MySaasPackage\Validation\RuleValidationResult;
use MySaasPackage\Validation\Violation;

class NotEmpty implements Rule
{
    public const KEYWORD = 'value.empty';

    public function validate(mixed $value): RuleValidationResult
    {
        if (!empty($value)) {
            return RuleValidationResult::succeeded();
        }

        return RuleValidationResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: 'The value cannot be empty'
            )
        );
    }
}
