<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;

class Structure implements Validatable
{
    public const KEYWORD = 'schema.mismatch';

    public function __construct(
        public readonly array $properties = []
    ) {
    }

    public function addRules(string $property, Validatable $rule): void
    {
        $this->properties[$property] = $rule;
    }

    public function validate(mixed $value): SchemaResult
    {
        $results = [];
        foreach ($this->properties as $property => $rule) {
            $value[$property] ??= null;

            $result = $rule->validate($value[$property]);

            if ($result->isSucceeded()) {
                continue;
            }

            $results[] = new SchemaPropertyResult($property, $result);
        }

        return new SchemaResult($results);
    }
}
