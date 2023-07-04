<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Rule;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\ViolationsResult;

class PhoneType implements Rule
{
    public const KEYWORD = 'phone.type.mismatch';

    public const REGEX = '/^\+(?:\d){6,14}\d$/';

    public function validate(mixed $value = null): ViolationsResult
    {
        if ((bool) preg_match(self::REGEX, (string) $value)) {
            return ViolationsResult::succeeded();
        }

        return ViolationsResult::failed(
            new Violation(
                self::KEYWORD,
                args: $value,
                message: 'The value provided must be a valid phone number',
            )
        );
    }
}
