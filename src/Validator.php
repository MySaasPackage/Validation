<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class Validator extends Chained
{
    public static function create(): self
    {
        return new self();
    }
}
