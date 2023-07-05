<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\ViolationsResult;

class NotNull implements Validatable
{
    public const KEYWORD = 'value.null';

    public function validate(mixed $value = null): ViolationsResult
    {
        if (!empty($value)) {
            return ViolationsResult::succeeded();
        }

        return ViolationsResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: 'The value cannot be null'
            )
        );
    }
}
