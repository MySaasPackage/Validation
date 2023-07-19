<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

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
        $minLengthResult = $this->minLength->validate($value);
        $maxLengthResult = $this->maxLength->validate($value);

        if ($minLengthResult->isSucceeded()) {
            return $maxLengthResult;
        }

        if ($maxLengthResult->isSucceeded()) {
            return $minLengthResult;
        }

        return $minLengthResult->merge($maxLengthResult);
    }
}
