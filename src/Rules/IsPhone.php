<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleResult;
use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class IsPhone implements Validatable
{
    public const KEYWORD = 'phone.mismatch';

    public const REGEX = '/^\+(?:\d){6,14}\d$/';

    public function validate(mixed $value = null): RuleResult
    {
        if ((bool) preg_match(self::REGEX, (string) $value)) {
            return RuleResult::succeeded();
        }

        return RuleResult::failed(
            new Violation(
                self::KEYWORD,
                message: 'The provided value is not a phone',
            )
        );
    }
}
