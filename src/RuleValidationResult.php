<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class RuleValidationResult
{
    public function __construct(
        protected readonly array $violations = []
    ) {
    }

    public static function failed(Violation ...$violations): RuleValidationResult
    {
        return new RuleValidationResult($violations);
    }

    public static function ok(): RuleValidationResult
    {
        return new RuleValidationResult();
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

    public function merge(RuleValidationResult $result): RuleValidationResult
    {
        return new RuleValidationResult(
            array_merge($this->violations, $result->getViolations())
        );
    }

    public function __toArray(): array
    {
        return array_map(static fn (Violation $error) => $error->__toArray(), $this->violations);
    }
}
