<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Rule;
use MySaasPackage\Validation\ViolationsResult;

class Optional implements Rule
{
    public function validate(mixed $value = null): ViolationsResult
    {
        return ViolationsResult::succeeded();
    }
}
