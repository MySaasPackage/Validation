<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\NamedViolation;
use MySaasPackage\Validation\Violations\SimpleViolation;

class ObjectStructure implements Validatable
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

        if (!is_object($value)) {
            return new SimpleViolation(keyword: 'object.mismatch', message: 'The provided value must be an object');
        }

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
