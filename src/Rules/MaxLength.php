<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleNode;
use MySaasPackage\Validation\Violation;
use InvalidArgumentException;

class MaxLength extends RuleNode
{
    public function __construct(
        protected string|int $maxLength,
    ) {
        if (!is_numeric($maxLength)) {
            throw new InvalidArgumentException('MaxLength must be a number');
        }

        $this->maxLength = (int) $maxLength;
    }

    public function getViolations(): array
    {
        return [
            new Violation(
                keyword: 'max.length.mismatch',
                args: [
                    'maxLength' => $this->maxLength,
                ],
            ),
        ];
    }

    protected function isValid(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return strlen($value) <= $this->maxLength;
    }
}
