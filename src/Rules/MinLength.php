<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use InvalidArgumentException;
use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\SimpleViolation;

use function is_numeric;
use function is_string;
use function strlen;

class MinLength implements Validatable
{
    public const KEYWORD = 'min.length.mismatch';

    public function __construct(
        protected string|int $minLength,
    ) {
        if (!is_numeric($minLength)) {
            throw new InvalidArgumentException('MinLength param must be a number');
        }

        $this->minLength = (int) $minLength;
    }

    public function validate(mixed $value): Violation|null
    {
        if (is_string($value) && strlen($value) >= $this->minLength) {
            return null;
        }

        return new SimpleViolation(
            keyword: self::KEYWORD,
            message: MessageFormatter::format('The provided value must be at least {minLength} characters', ['minLength' => $this->minLength]),
        );
    }
}
