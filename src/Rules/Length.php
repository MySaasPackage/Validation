<?php

declare(strict_types=1);

namespace Eclesi\Validation\Rules;

use Eclesi\Validation\RuleNode;

class Length extends RuleNode
{
    public function __construct(
        protected readonly MinLength $minLength,
        protected readonly MaxLength $maxLength,
    ) {
    }

    public function getViolations(): array
    {
        return array_merge($this->minLength->getViolations(), $this->maxLength->getViolations());
    }

    protected function isValid(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        if (!$this->minLength->isValid($value)) {
            return false;
        }

        return $this->maxLength->isValid($value);
    }
}
