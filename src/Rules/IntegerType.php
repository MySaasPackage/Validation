<?php

declare(strict_types=1);

namespace Eclesi\Validation\Rules;

use Eclesi\Validation\RuleNode;
use Eclesi\Validation\Violation;

class IntegerType extends RuleNode
{
    public function getViolations(): array
    {
        return [
            new Violation(
                keyword: 'integer.type.mismatch',
            ),
        ];
    }

    protected function isValid(mixed $value): bool
    {
        return is_int($value);
    }
}
