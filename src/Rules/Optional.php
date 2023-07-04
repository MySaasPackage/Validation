<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Rule;
use MySaasPackage\Validation\RuleValidationResult;

class Optional implements Rule
{
    public function validate(mixed $value = null): RuleValidationResult
    {
        return RuleValidationResult::succeeded();
    }
}
