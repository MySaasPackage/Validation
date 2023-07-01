<?php

declare(strict_types=1);

namespace Eclesi\Validation\Rules;

use Eclesi\Validation\RuleNode;
use Eclesi\Validation\Violation;

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
