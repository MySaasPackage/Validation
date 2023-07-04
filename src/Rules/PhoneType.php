<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleValidation;
use MySaasPackage\Validation\RuleValidationResult;
use MySaasPackage\Validation\Violation;

class PhoneType implements RuleValidation
{
    public const KEYWORD = 'phone.type.mismatch';

    public const REGEX = '/^\+(?:\d){6,14}\d$/';

    public function validate(mixed $value = null): RuleValidationResult
    {
        if ((bool) preg_match(self::REGEX, (string) $value)) {
            return RuleValidationResult::succeeded();
        }

        return RuleValidationResult::failed(
            new Violation(
                self::KEYWORD,
                args: $value,
                message: 'The value provided must be a valid phone number',
            )
        );
    }
}
