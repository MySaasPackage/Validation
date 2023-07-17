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

    public function merge(ValidatableResult $result): self
    {
        if ($result->isSucceeded()) {
            return $this;
        }

        if ($this->isSucceeded()) {
            return $result;
        }

        $this->violation->addSibling($result->getViolation());

        return $this;
    }
}
