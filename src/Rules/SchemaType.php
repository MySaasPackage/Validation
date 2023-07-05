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

    public function validate(mixed $value): ViolationsResult
    {
        if (!is_array($value)) {
            return ViolationsResult::failed(new Violation(self::KEYWORD, 'The value must be an array'));
        }

        $result = [];
        foreach ($this->properties as $property => $ruleOrSchema) {
            $toValidate = $value[$property] ?? null;
            $result[$property] = $ruleOrSchema->validate($toValidate);
        }

        return new ViolationsResult($result);
    }
}
