<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\ViolationsResult;

class CollectionType implements Validatable
{
    public const KEYWORD = 'collection.type.mismatch';

    public function __construct(
        protected readonly Validatable $type
    ) {
    }

    public function validate(mixed $value): ViolationsResult
    {
        if (!is_array($value)) {
            return ViolationsResult::failed(
                new Violation(
                    self::KEYWORD,
                    'The value must be an array'
                )
            );
        }

        $violations = [];

        foreach ($value as $item) {
            $violations = array_merge(
                $violations,
                $this->type->validate($item)->getViolations()
            );
        }

        return ViolationsResult::create(...$violations);
    }
}
