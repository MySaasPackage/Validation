<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

class SchemaPropertyResult
{
    public function __construct(
        protected readonly string $property,
        protected readonly RuleResult $ruleResult
    ) {
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getRuleResult(): RuleResult
    {
        return $this->ruleResult;
    }

    public function isSucceeded(): bool
    {
        return $this->ruleResult->isSucceeded();
    }

    public function isFailed(): bool
    {
        return $this->ruleResult->isFailed();
    }

    public function getViolations(): array
    {
        return $this->ruleResult->getViolations();
    }

    public function __toArray(): array
    {
        return [$this->property => $this->ruleResult->__toArray()];
    }
}
