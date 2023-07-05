<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\ViolationsResult;

class IntegerType implements Validatable
{
    public const KEYWORD = 'integer.type.mismatch';

    public function validate(mixed $value): ViolationsResult
    {
        if (is_int($value)) {
            return ViolationsResult::succeeded();
        }

        return ViolationsResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: MessageFormatter::format('The value must be a integer, got {type}', ['type' => gettype($value)])
            )
        );
    }
}
