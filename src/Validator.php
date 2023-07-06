<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class Validator extends ChainedValidator
{
    public static function create(): self
    {
        return new self();
    }
}
