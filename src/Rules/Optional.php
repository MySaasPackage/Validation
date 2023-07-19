<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;

class Optional implements Validatable
{
    public function validate(mixed $value = null): RuleResult
    {
        return RuleResult::succeeded();
    }
}
