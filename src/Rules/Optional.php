<?php

declare(strict_types=1);

namespace Eclesi\Validation\Rules;

use Eclesi\Validation\RuleNode;

class Optional extends RuleNode
{
    public function getViolations(): array
    {
        return [];
    }

    public function isEmpty(mixed $value): bool
    {
        return $this->isValid($value);
    }

    protected function isValid(mixed $value): bool
    {
        return null === $value;
    }
}
