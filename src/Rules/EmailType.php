<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\ViolationsResult;

class EmailType implements Validatable
{
    public const REGEX = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,5}$/';

    public const KEYWORD = 'email.type.mismatch';

    public function validate(mixed $value): ViolationsResult
    {
        if (is_string($value) && (bool) preg_match(self::REGEX, (string) $value)) {
            return ViolationsResult::succeeded();
        }

        return ViolationsResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: 'The value provided must be a valid email'
            )
        );
    }
}
