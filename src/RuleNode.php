<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class RuleNode
{
    public RuleNode|null $next = null;

    public function __construct(
        public readonly Rule $rule,
    ) {
    }

    public function hasNext(): bool
    {
        return $this->next instanceof RuleNode;
    }

    public function setNextRule(RuleNode $rule): void
    {
        $this->next = $rule;
    }

    public function validate(mixed $value): RuleValidationResult
    {
        $result = $this->rule->validate($value);

        if ($result->isSucceeded() && $this->hasNext()) {
            return $this->next->validate($value);
        }

        return $result;
    }
}
