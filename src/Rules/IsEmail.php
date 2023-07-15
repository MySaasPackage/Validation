<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;
use MySaasPackage\Validation\Violation;

class IsEmail implements Validatable
{
    public const REGEX = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,5}$/';

    public const KEYWORD = 'email.mismatch';

    public function validate(mixed $value): ValidatableResult
    {
        if (is_string($value) && (bool) preg_match(self::REGEX, (string) $value)) {
            return ValidatableResult::succeeded();
        }

        return ValidatableResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: 'The provided value is not a email'
            )
        );
    }
}
