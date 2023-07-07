<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class RuleResult
{
    public function __construct(
        protected readonly array $violations = []
    ) {
    }

    public static function create(Violation ...$violations): RuleResult
    {
        return new RuleResult($violations);
    }

    public static function failed(Violation ...$violations): RuleResult
    {
        return new RuleResult($violations);
    }

    public static function succeeded(): RuleResult
    {
        return new RuleResult();
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

    public function merge(RuleResult ...$results): RuleResult
    {
        $violations = array_merge(
            ...array_map(static function ($result) {
                if ($result instanceof RuleResult) {
                    return $result->getViolations();
                }

                return $result;
            }, $results)
        );

        return RuleResult::create(...$this->violations, ...$violations);
    }

    public function __toArray(): array
    {
        return array_map(fn ($violation) => $violation->__toArray(), $this->violations);
    }
}
