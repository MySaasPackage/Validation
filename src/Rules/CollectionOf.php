<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\NamedViolation;

class CollectionOf implements Validatable
{
    public function __construct(
        protected readonly Validatable $rule
    ) {
    }

    public static function create(Validatable $rule): self
    {
        return new self($rule);
    }

    public function validate(mixed $value): Violation|null
    {
        $violationOrNull = null;

        $value ??= [null];
        foreach ($value as $key => $item) {
            $keyViolationOrNull = $this->rule->validate($item);

            if (null === $keyViolationOrNull) {
                continue;
            }

            if ($violationOrNull instanceof NamedViolation) {
                $violationOrNull->addSibling(new NamedViolation(sprintf('%s', $key), $keyViolationOrNull));
            }

            $violationOrNull ??= new NamedViolation(sprintf('%s', $key), $keyViolationOrNull);
        }

        return $violationOrNull;
    }
}
