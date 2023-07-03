<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleValidation;
use MySaasPackage\Validation\RuleValidationResult;
use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Violation;

class IntegerType implements RuleValidation
{
    public const KEYWORD = 'integer.type.mismatch';

    public function validate(mixed $value): RuleValidationResult
    {
        if (is_int($value)) {
            return RuleValidationResult::succeeded();
        }

        return RuleValidationResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: MessageFormatter::format('The value must be a integer, got {type}', ['type' => gettype($value)])
            )
        );
    }
}
