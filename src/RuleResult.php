<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class RuleResult implements ValidatableResult
{
    public function __construct(
        protected readonly Violation|null $violation = null,
    ) {
    }

    public static function succeeded(): self
    {
        return new self();
    }

    public static function failed(Violation $violation): self
    {
        return new self($violation);
    }

    public function isSucceeded(): bool
    {
        return null === $this->violation;
    }

    public function isFailed(): bool
    {
        return null !== $this->violation;
    }

    public function getViolation(): Violation|null
    {
        return $this->violation;
    }

    public function merge(RuleResult $result): self
    {
        if ($this->isSucceeded()) {
            return $result;
        }

        if ($result->isSucceeded()) {
            return $this;
        }

        $this->violation->addSibling($result->getViolation());

        return $this;
    }

    public function __toArray(): array
    {
        return $this->violation->__toArray();
    }
}
