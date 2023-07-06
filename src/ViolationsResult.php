<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class ViolationsResult
{
    public function __construct(
        protected readonly array $violations = []
    ) {
    }

    public static function create(Violation ...$violations): ViolationsResult
    {
        return new ViolationsResult($violations);
    }

    public static function failed(Violation ...$violations): ViolationsResult
    {
        return new ViolationsResult($violations);
    }

    public static function succeeded(): ViolationsResult
    {
        return new ViolationsResult();
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

    public static function merge(ViolationsResult ...$results): ViolationsResult
    {
        $violations = array_merge(
            ...array_map(static function ($result) {
                if ($result instanceof ViolationsResult) {
                    return $result->getViolations();
                }

                return $result;
            }, $results)
        );

        return ViolationsResult::create(...$violations);
    }

    public function __toArray(): array
    {
        return array_map(fn ($violation) => $violation->__toArray(), $this->violations);
    }
}
