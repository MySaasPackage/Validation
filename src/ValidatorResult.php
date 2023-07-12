<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

interface ValidatorResult
{
    public function isSucceeded(): bool;

    public function isFailed(): bool;

    public function getViolations(): array;
}
