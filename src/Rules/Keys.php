<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\FieldViolation;

class Keys implements Validatable
{
    public array $keys;

    public static function create(): self
    {
        return new self();
    }

    public function key(string $key, Validatable $rule): self
    {
        $this->keys[$key] = $rule;

        return $this;
    }

    public function validate(mixed $value): Violation|null
    {
        $violationOrNull = null;

        foreach ($this->keys as $key => $rule) {
            $value[$key] ??= null;

            $keyViolationOrNull = $rule->validate($value[$key]);

            if (null === $keyViolationOrNull) {
                continue;
            }

            if ($violationOrNull instanceof FieldViolation) {
                $violationOrNull->addSibling(new FieldViolation($key, $keyViolationOrNull));
            }

            $violationOrNull ??= new FieldViolation($key, $keyViolationOrNull);
        }

        return $violationOrNull;
    }
}
