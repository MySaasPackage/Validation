<?php

declare(strict_types=1);

namespace Eclesi\Validation;

interface Coerce
{
    public function coerce(ValidatorInput $input): ValidatorResult;
}
