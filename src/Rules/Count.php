<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\SimpleViolation;

class Count implements Validatable
{
    public const KEYWORD = 'count.mismatch';

    public function __construct(
        protected int $expected
    ) {
    }

    public function validate(mixed $value): Violation|null
    {
        echo 'Value: '.$value.PHP_EOL;
        echo 'Expected: '.$this->expected.PHP_EOL;

        if (count($value) === $this->expected) {
            return null;
        }

        return new SimpleViolation(
            keyword: self::KEYWORD,
            message: MessageFormatter::format('The provided structure does not have exactly {number} elements', ['number' => $this->expected])
        );
    }
}
