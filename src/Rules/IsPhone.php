<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;
use MySaasPackage\Validation\Violation;

class IsPhone implements Validatable
{
    public const KEYWORD = 'phone.mismatch';

    public const REGEX = '/^\+(?:\d){6,14}\d$/';

    public function validate(mixed $value = null): ValidatableResult
    {
        if ((bool) preg_match(self::REGEX, (string) $value)) {
            return ValidatableResult::succeeded();
        }

        return ValidatableResult::failed(
            new Violation(
                self::KEYWORD,
                args: $value,
                message: 'The provided value is not a phone',
            )
        );
    }
}
