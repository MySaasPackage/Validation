<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use InvalidArgumentException;
use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;
use MySaasPackage\Validation\Violation;

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

    public function validate(mixed $value): ValidatableResult
    {
        if (is_string($value) && strlen($value) >= $this->minLength) {
            return ValidatableResult::succeeded();
        }

        return ValidatableResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: MessageFormatter::format('The value must be at least {minLength} characters', ['minLength' => $this->minLength]),
            )
        );
    }
}
