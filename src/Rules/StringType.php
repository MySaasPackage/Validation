<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class StringType implements Validatable
{
    public const KEYWORD = 'string.type.mismatch';

    public function validate(mixed $value): RuleResult
    {
        if (is_string($value)) {
            return RuleResult::succeeded();
        }

        return RuleResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: MessageFormatter::format('The value must be a string, you provide {type}', ['type' => gettype($value)])
            )
        );
    }
}
