<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use InvalidArgumentException;
use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\ViolationsResult;

class MaxLength implements Validatable
{
    public const KEYWORD = 'max.length.mismatch';

    public function __construct(
        protected string|int $maxLength,
    ) {
        if (!is_numeric($maxLength)) {
            throw new InvalidArgumentException('MaxLength must be a number');
        }

        $this->maxLength = (int) $maxLength;
    }

    public function validate(mixed $value): ViolationsResult
    {
        if (is_string($value) && strlen($value) <= $this->maxLength) {
            return ViolationsResult::succeeded();
        }

        return ViolationsResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: MessageFormatter::format('The value must be less than {maxLength} characters', ['maxLength' => $this->maxLength])
            )
        );
    }
}
