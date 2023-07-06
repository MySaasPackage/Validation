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

        $violationsResult = [];
        foreach ($value as $key => $item) {
            $itemViolationsResult = $this->type->validate($item);
            if ($itemViolationsResult->isSucceeded()) {
                continue;
            }

            $violationsResult[$key] = $itemViolationsResult;
        }

        return new ViolationsResult($violationsResult);
    }
}
