<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class Length implements Validatable
{
    public function __construct(
        protected readonly MinLength $minLength,
        protected readonly MaxLength $maxLength,
    ) {
    }

    public function validate(mixed $value): Violation
    {
        $minLengthViolationOrNull = $this->minLength->validate($value);
        $maxLengthViolationOrNull = $this->maxLength->validate($value);

        if (null === $minLengthViolationOrNull) {
            return $maxLengthViolationOrNull;
        }

        if (null === $maxLengthViolationOrNull) {
            return $minLengthViolationOrNull;
        }

        return $minLengthViolationOrNull->addSibling($maxLengthViolationOrNull);
    }
}
