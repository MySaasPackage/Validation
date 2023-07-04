<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleValidation;
use MySaasPackage\Validation\RuleValidationResult;
use MySaasPackage\Validation\Violation;

class NotNull implements RuleValidation
{
    public const KEYWORD = 'value.null';

    public function validate(mixed $value): RuleValidationResult
    {
        if (!empty($value)) {
            return RuleValidationResult::succeeded();
        }

        return RuleValidationResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: 'Value cannot be null'
            )
        );
    }
}
