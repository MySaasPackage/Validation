<?php

declare(strict_types=1);

namespace Eclesi\Validation\Rules;

use Eclesi\Validation\RuleNode;
use Eclesi\Validation\ValidatorInput;
use Eclesi\Validation\Violation;
use InvalidArgumentException;

class SameAs extends RuleNode
{
    public function __construct(
        protected readonly string $originalProperty,
        protected readonly string $shouldBeEqualsTo
    ) {
    }

    public function getViolations(): array
    {
        return [
            new Violation(
                keyword: 'same.value.mismatch',
                args: [
                    'originalProperty' => $this->originalProperty,
                    'shouldBeEqualsTo' => $this->shouldBeEqualsTo,
                ],
            ),
        ];
    }

    protected function isValid(mixed $value): bool
    {
        if (!$value instanceof ValidatorInput) {
            throw new InvalidArgumentException('The value must be an instance of CoerceInput');
        }

        $expect = $value->getOrNull($this->originalProperty);
        $result = $value->getOrNull($this->shouldBeEqualsTo);

        if (!is_null($expect)) {
            return $expect === $result;
        }

        if (!is_null($result)) {
            return $expect === $result;
        }

        return false;
    }
}
