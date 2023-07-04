<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleValidation;
use MySaasPackage\Validation\RuleValidationResult;

class Optional implements RuleValidation
{
    public function validate(mixed $value = null): RuleValidationResult
    {
        return RuleValidationResult::succeeded();
    }
}
