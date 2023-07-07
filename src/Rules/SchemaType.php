<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class SchemaType implements Validatable
{
    public const KEYWORD = 'schema.mismatch';

    public function __construct(
        public readonly array $properties = []
    ) {
    }

    public function addRules(string $property, Validatable|SchemaType $ruleOrSchema): void
    {
        $this->properties[$property] = $ruleOrSchema;
    }

    public function validate(mixed $value): RuleResult
    {
        if (!is_array($value)) {
            return RuleResult::failed(new Violation(self::KEYWORD, 'The value must be an array'));
        }

        $schemaResult = [];
        foreach ($this->properties as $property => $ruleOrSchema) {
            $value[$property] ??= null;

            $result = $ruleOrSchema->validate($value[$property]);

            if ($result->isSucceeded()) {
                continue;
            }

            $schemaResult[$property] = $result;
        }

        return new RuleResult($schemaResult);
    }
}
