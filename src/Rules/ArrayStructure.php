<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\NamedViolation;
use MySaasPackage\Validation\Violations\SimpleViolation;

use function is_array;

class ArrayStructure implements Validatable
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

        if (!is_array($value)) {
            return new SimpleViolation(keyword: 'array.mismatch', message: 'The provided value must be an array');
        }

        foreach ($this->keys as $key => $rule) {
            $value[$key] ??= null;

            $keyViolationOrNull = $rule->validate($value[$key]);

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
