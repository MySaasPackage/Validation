<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class ChainRule
{
    public ChainRule|null $next = null;

    public function __construct(
        public readonly Rule $rule,
    ) {
    }

    public function hasNext(): bool
    {
        return $this->next instanceof ChainRule;
    }

    public function setNextRule(ChainRule $rule): void
    {
        $this->next = $rule;
    }

    public function validate(mixed $value): ViolationsResult
    {
        $result = $this->rule->validate($value);

        if ($result->isSucceeded() && $this->hasNext()) {
            return $this->next->validate($value);
        }

        return $result;
    }
}
