<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class Chain
{
    public Chain|null $next = null;

    public function __construct(
        public readonly Validatable $rule,
    ) {
    }

    public function hasNext(): bool
    {
        return $this->next instanceof Chain;
    }

    public function setNextRule(Chain $rule): void
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
