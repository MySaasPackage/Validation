<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ViolationsResult;

class Optional implements Validatable
{
    public function validate(mixed $value = null): ViolationsResult
    {
        return ViolationsResult::succeeded();
    }
}
