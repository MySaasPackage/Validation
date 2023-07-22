<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

interface Validatable
{
    public function validate(mixed $value): Violation|null;
}
