<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleResult;
use MySaasPackage\Validation\Validatable;

class Length implements Validatable
{
    public function __construct(
        protected readonly MinLength $minLength,
        protected readonly MaxLength $maxLength,
    ) {
    }

    public function validate(mixed $value): RuleResult
    {
        $minValidationResult = $this->minLength->validate($value);
        $maxValidationResult = $this->maxLength->validate($value);

        return $minValidationResult->merge($maxValidationResult);
    }
}
