<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleValidation;
use MySaasPackage\Validation\RuleValidationResult;
use MySaasPackage\Validation\Violation;

class EmailType implements RuleValidation
{
    public const REGEX = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,5}$/';

    public const KEYWORD = 'email.type.mismatch';

    public function validate(mixed $value): RuleValidationResult
    {
        if (is_string($value) && (bool) preg_match(self::REGEX, (string) $value)) {
            return RuleValidationResult::succeeded();
        }

        return RuleValidationResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: 'The value provided must be a valid email'
            )
        );
    }
}
