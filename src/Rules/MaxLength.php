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

class MaxLength implements Validatable
{
    public const KEYWORD = 'max.length.mismatch';

    public function __construct(
        protected string|int $maxLength,
    ) {
        if (!is_numeric($maxLength)) {
            throw new InvalidArgumentException('MaxLength param must be a valid number');
        }

        $this->maxLength = (int) $maxLength;
    }

    public function validate(mixed $value): Violation|null
    {
        if (is_string($value) && strlen($value) <= $this->maxLength) {
            return null;
        }

        return new SimpleViolation(
            keyword: self::KEYWORD,
            message: MessageFormatter::format('The provided value must be less than {maxLength} characters', ['maxLength' => $this->maxLength])
        );
    }
}
