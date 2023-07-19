<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

interface ValidatableResult
{
    public function isSucceeded(): bool;

    public function isFailed(): bool;

    public function __toArray(): array;
}
