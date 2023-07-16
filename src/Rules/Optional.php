<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;

class Optional implements Validatable
{
    public function validate(mixed $value = null): ValidatableResult
    {
        return ValidatableResult::succeeded();
    }
}
