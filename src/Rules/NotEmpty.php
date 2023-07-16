<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;
use MySaasPackage\Validation\Violation;

class NotEmpty implements Validatable
{
    public const KEYWORD = 'value.empty';

    public function validate(mixed $value): ValidatableResult
    {
        if (!empty($value)) {
            return ValidatableResult::succeeded();
        }

        return ValidatableResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: 'The provided value cannot be empty'
            )
        );
    }
}
