<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class ValidatableResult
{
    public function __construct(
        protected readonly ?Violation $violation = null,
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

    public function getViolation(): ?Violation
    {
        return $this->violation;
    }
}
