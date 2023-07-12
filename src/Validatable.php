<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use MySaasPackage\Validation\Rules\RuleResult;
use MySaasPackage\Validation\Rules\SchemaResult;

interface Validatable
{
    public function validate(mixed $value): RuleResult|SchemaResult;
}
