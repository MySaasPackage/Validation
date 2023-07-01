<?php

declare(strict_types=1);

namespace Eclesi\Validation\Rules;

use Eclesi\Validation\RuleValidationResult;
use Eclesi\Validation\Utils\MessageFormatter;
use Eclesi\Validation\Violation;

class StringType
{
    public const KEYWORD = 'string.type.mismatch';

    public function validate(mixed $value): RuleValidationResult
    {
        if (is_string($value)) {
            return RuleValidationResult::ok();
        }

        return RuleValidationResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: MessageFormatter::format('The value must be a string, got {type}', ['type' => gettype($value)])
            )
        );
    }
}
