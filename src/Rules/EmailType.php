<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleNode;
use MySaasPackage\Validation\Violation;

class EmailType extends RuleNode
{
    public const REGEX = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,5}$/';

    public function getViolations(): array
    {
        return [
            new Violation(
                keyword: 'email.type.mismatch',
            ),
        ];
    }

    protected function isValid(mixed $value): bool
    {
        return (bool) preg_match(self::REGEX, (string) $value);
    }
}
