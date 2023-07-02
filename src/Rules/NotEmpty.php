<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleNode;
use MySaasPackage\Validation\Violation;

class NotEmpty extends RuleNode
{
    public function getViolations(): array
    {
        return [
            new Violation(
                keyword: 'value.is_empty',
            ),
        ];
    }

    protected function isValid(mixed $value): bool
    {
        return !empty($value);
    }
}
