<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\FieldViolation;

class Structure implements Validatable
{
    public array $structure;

    public static function create(): self
    {
        return new self();
    }

    public function add(string $key, Validatable $rule): self
    {
        $this->structure[$key] = $rule;

        return $this;
    }

    public function validate(mixed $value): Violation|null
    {
        $structure = new Violation(keword: 'structure', message: 'Invalid structure');

        foreach ($this->structure as $key => $validatable) {
            $value[$key] ??= null;

            $violationOrNull = $validatable->validate($value[$key]);

            if (null === $violationOrNull) {
                continue;
            }

            $structure->addSibling(new FieldViolation($key, $violationOrNull));
        }

        if ($structure->hasSibling()) {
            return $structure;
        }

        return null;
    }
}
