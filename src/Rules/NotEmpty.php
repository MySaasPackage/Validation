<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class NotEmpty implements Validatable
{
    public const KEYWORD = 'value.empty';

    public function validate(mixed $value): RuleResult
    {
        if (!empty($value)) {
            return RuleResult::succeeded();
        }

        return RuleResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: 'The value cannot be empty'
            )
        );
    }
}
