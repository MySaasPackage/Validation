<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\ValidatorResult;
use MySaasPackage\Validation\Violation;

class RuleResult implements ValidatorResult
{
    public function __construct(
        protected readonly array $violations = []
    ) {
    }

    public static function create(Violation ...$violations): self
    {
        return new self($violations);
    }

    public static function failed(Violation ...$violations): self
    {
        return new self($violations);
    }

    public static function succeeded(): self
    {
        return new self();
    }

    public function isSucceeded(): bool
    {
        return [] === $this->violations;
    }

    public function isFailed(): bool
    {
        return [] !== $this->violations;
    }

    public function getViolations(): array
    {
        return $this->violations;
    }

    public function merge(self $results): self
    {
        return new self(array_merge($this->violations, $results->getViolations()));
    }

    public function __toArray(): array
    {
        return array_map(fn ($violation) => $violation->__toArray(), $this->violations);
    }
}
