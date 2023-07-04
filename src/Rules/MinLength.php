<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use InvalidArgumentException;
use MySaasPackage\Validation\Rule;
use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\ViolationsResult;

class MinLength implements Rule
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

    public function validate(mixed $value): ViolationsResult
    {
        if (is_string($value) && strlen($value) >= $this->minLength) {
            return ViolationsResult::succeeded();
        }

        return ViolationsResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: MessageFormatter::format('The value must be at least {minLength} characters long', [
                    'minLength' => $this->minLength,
                ]),
            )
        );
    }
}
