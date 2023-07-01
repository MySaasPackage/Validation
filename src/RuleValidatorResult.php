<?php

declare(strict_types=1);

namespace Eclesi\Validation;

class RuleValidatorResult
{
    public function __construct(
        protected readonly array $violations = []
    ) {
    }

    public function isValid(): bool
    {
        return [] === $this->violations;
    }

    public function isNotValid(): bool
    {
        return [] !== $this->violations;
    }

    public function getViolations(): array
    {
        return $this->violations;
    }

    public function merge(RuleValidatorResult $result): RuleValidatorResult
    {
        return new RuleValidatorResult(
            array_merge($this->violations, $result->getViolations())
        );
    }

    public function __toArray(): array
    {
        return array_map(static fn (Violation $error) => $error->__toArray(), $this->violations);
    }
}
