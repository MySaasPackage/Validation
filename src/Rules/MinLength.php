<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleNode;
use MySaasPackage\Validation\Violation;
use InvalidArgumentException;

class MinLength extends RuleNode
{
    public function __construct(
        protected string|int $minLength,
    ) {
        if (!is_numeric($minLength)) {
            throw new InvalidArgumentException('MinLength must be a number');
        }

        $this->minLength = (int) $minLength;
    }

    public function getViolations(): array
    {
        return [
            new Violation(
                keyword: 'min.length.mismatch',
                args: [
                    'minLength' => $this->minLength,
                ],
            ),
        ];
    }

    protected function isValid(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return strlen($value) >= $this->minLength;
    }
}
