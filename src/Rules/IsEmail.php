<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleResult;
use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class IsEmail implements Validatable
{
    public const REGEX = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,5}$/';

    public const KEYWORD = 'email.mismatch';

    public function validate(mixed $value): RuleResult
    {
        if (is_string($value) && (bool) preg_match(self::REGEX, (string) $value)) {
            return RuleResult::succeeded();
        }

        return RuleResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                message: 'The provided value is not a email'
            )
        );
    }
}
