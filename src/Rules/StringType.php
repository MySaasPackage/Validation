<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleValidation;
use MySaasPackage\Validation\RuleValidationResult;
use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Violation;

class StringType implements RuleValidation
{
    public const KEYWORD = 'string.type.mismatch';

    public function validate(mixed $value): RuleValidationResult
    {
        if (is_string($value)) {
            return RuleValidationResult::succeeded();
        }

        return RuleValidationResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: MessageFormatter::format('The value must be a string, you provide {type}', ['type' => gettype($value)])
            )
        );
    }
}
