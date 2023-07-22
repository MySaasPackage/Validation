<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\SimpleViolation;

class IsPhone implements Validatable
{
    public const KEYWORD = 'phone.mismatch';

    public const REGEX = '/^\+(?:\d){6,14}\d$/';

    public function validate(mixed $value = null): Violation|null
    {
        if ((bool) preg_match(self::REGEX, (string) $value)) {
            return null;
        }

        return new SimpleViolation(
            self::KEYWORD,
            message: 'The provided value must be a valid phone',
        );
    }
}
