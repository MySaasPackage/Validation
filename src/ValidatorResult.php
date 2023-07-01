<?php

declare(strict_types=1);

namespace Eclesi\Validation;

class ValidatorResult
{
    public function __construct(
        protected readonly ValidatorInput $input,
        protected readonly array $violations = []
    ) {
    }

    public function getInput(): ValidatorInput
    {
        return $this->input;
    }

    public function getViolations(): array
    {
        return $this->violations;
    }

    public function isNotValid(): bool
    {
        return [] !== $this->violations;
    }

    public function isValid(): bool
    {
        return [] === $this->violations;
    }

    public function __toArray(): array
    {
        return $this->violations;
    }
}
