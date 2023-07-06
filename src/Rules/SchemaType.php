<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\ViolationsResult;

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

    protected function validateCollection(Validatable $ruleOrSchema, array $values): ViolationsResult
    {
        $collectionResult = [];
        foreach ($values as $key => $value) {
            $ruleOrSchemaResult = $ruleOrSchema->validate($value);

            if ($ruleOrSchemaResult->isSucceeded()) {
                continue;
            }

            $collectionResult[$key] = $ruleOrSchemaResult;
        }

        return new ViolationsResult($collectionResult);
    }

    protected function validateSingle(Validatable $ruleOrSchema, mixed $value): ViolationsResult
    {
        return $ruleOrSchema->validate($value);
    }

    protected function validateSingleOrCollection(Validatable $ruleOrSchema, mixed $value): ViolationsResult
    {
        if (is_array($value)) {
            return $this->validateCollection($ruleOrSchema, $value);
        }

        return $this->validateSingle($ruleOrSchema, $value);
    }

    public function validate(mixed $value): ViolationsResult
    {
        if (!is_array($value)) {
            return ViolationsResult::failed(new Violation(self::KEYWORD, 'The value must be an array'));
        }

        $schemaResult = [];
        foreach ($this->properties as $property => $ruleOrSchema) {
            $value[$property] ??= null;

            $result = $this->validateSingleOrCollection($ruleOrSchema, $value[$property]);

            if ($result->isSucceeded()) {
                continue;
            }

            $schemaResult[$property] = $result;
        }

        return new ViolationsResult($schemaResult);
    }
}
