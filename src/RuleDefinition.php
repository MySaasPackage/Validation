<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

readonly class RuleDefinition
{
    public function __construct(
        public string $rule,
        public array|null $args,
    ) {
    }

    public function hasArgs(): bool
    {
        return null !== $this->args && [] !== $this->args;
    }
}
