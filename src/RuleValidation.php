<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

interface RuleValidation
{
    public function validate(mixed $value): RuleValidationResult;
}
