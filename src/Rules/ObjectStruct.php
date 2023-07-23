<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\NamedViolation;

class ObjectStruct implements Validatable
{
    public array $keys;

    public static function create(): self
    {
        return new self();
    }

    public function property(string $key, Validatable $rule): self
    {
        $this->keys[$key] = $rule;

        return $this;
    }

    public function validate(mixed $value): Violation|null
    {
        $violationOrNull = null;

        foreach ($this->keys as $key => $rule) {
            $property = $value->$key ?? null;

            $keyViolationOrNull = $rule->validate($property);

            if (null === $keyViolationOrNull) {
                continue;
            }

            if ($violationOrNull instanceof NamedViolation) {
                $violationOrNull->addSibling(new NamedViolation($key, $keyViolationOrNull));
            }

            $violationOrNull ??= new NamedViolation($key, $keyViolationOrNull);
        }

        return $violationOrNull;
    }
}
