<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleResult;
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
                message: 'The provided value cannot be empty'
            )
        );
    }
}
