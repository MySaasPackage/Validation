<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

interface Coerce
{
    public function coerce(ValidatorInput $input): ValidatorResult;
}
