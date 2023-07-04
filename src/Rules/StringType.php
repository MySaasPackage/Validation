<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Rule;
use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\ViolationsResult;

class StringType implements Rule
{
    public const KEYWORD = 'string.type.mismatch';

    public function validate(mixed $value): ViolationsResult
    {
        if (is_string($value)) {
            return ViolationsResult::succeeded();
        }

        return ViolationsResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: MessageFormatter::format('The value must be a string, you provide {type}', ['type' => gettype($value)])
            )
        );
    }
}
