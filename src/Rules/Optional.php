<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleNode;

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
