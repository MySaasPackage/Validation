<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class NotNull implements Validatable
{
    public const KEYWORD = 'value.null';

    public function validate(mixed $value = null): RuleResult
    {
        if (!empty($value)) {
            return RuleResult::succeeded();
        }

        return RuleResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                message: 'The provided value cannot be null'
            )
        );
    }
}
