<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

interface Violation
{
    public function getSibling(): Violation|null;

    public function hasSibling(): bool;

    public function addSibling(Violation $violation): Violation;

    public function __toArray(): array;
}
