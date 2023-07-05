<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ViolationsResult;

class Length implements Validatable
{
    public function __construct(
        protected readonly MinLength $minLength,
        protected readonly MaxLength $maxLength,
    ) {
    }

    public function validate(mixed $value): ViolationsResult
    {
        $minValidationResult = $this->minLength->validate($value);
        $maxValidationResult = $this->maxLength->validate($value);

        return ViolationsResult::merge($minValidationResult, $maxValidationResult);
    }
}
