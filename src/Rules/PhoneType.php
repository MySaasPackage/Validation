<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleNode;
use MySaasPackage\Validation\Violation;

class PhoneType extends RuleNode
{
    public const REGEX = '/^\+(?:\d){6,14}\d$/';

    public function getViolations(): array
    {
        return [
            new Violation(
                keyword: 'phone.type.mismatch',
            ),
        ];
    }

    protected function isValid(mixed $value): bool
    {
        return (bool) preg_match(self::REGEX, (string) $value);
    }
}
