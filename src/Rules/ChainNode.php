<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;

class ChainNode
{
    public ChainNode|null $next = null;

    public function __construct(
        public readonly Validatable $rule,
    ) {
    }

    public function hasNext(): bool
    {
        return $this->next instanceof ChainNode;
    }

    public function setNextRule(ChainNode $rule): void
    {
        $this->next = $rule;
    }

    public function validate(mixed $value): ValidatableResult
    {
        $result = $this->rule->validate($value);

        if ($result->isSucceeded() && $this->hasNext()) {
            return $this->next->validate($value);
        }

        return $result;
    }
}
