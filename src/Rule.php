<?php

declare(strict_types=1);

namespace Eclesi\Validation;

abstract class RuleNode
{
    public RuleNode|null $next = null;

    abstract protected function isValid(mixed $value): bool;

    abstract public function getViolations(): array;

    public function hasNext(): bool
    {
        return $this->next instanceof RuleNode;
    }

    public function setNextRule(RuleNode $rule): void
    {
        $this->next = $rule;
    }

    public function validate(mixed $value): RuleValidatorResult
    {
        if ($this->isValid($value)) {
            return new RuleValidatorResult();
        }

        return new RuleValidatorResult($this->getViolations());
    }
}
