<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

interface Rule
{
    public function validate(mixed $value): RuleValidationResult;
}
