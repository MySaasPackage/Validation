<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class CollectionType implements Validatable
{
    public const KEYWORD = 'collection.type.mismatch';

    public function __construct(
        protected readonly Validatable $type
    ) {
    }

    public function validate(mixed $value): RuleResult
    {
        if (!is_array($value)) {
            return RuleResult::failed(
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

        return new RuleResult($violationsResult);
    }
}
