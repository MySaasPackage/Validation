<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;
use MySaasPackage\Validation\Violation;

class IsCollectionOf implements Validatable
{
    public const KEYWORD = 'collectionOf.mismatch';

    public function __construct(
        protected readonly Validatable $rule
    ) {
    }

    public function validate(mixed $value): ValidatableResult
    {
        if (false === is_array($value)) {
            return ValidatableResult::failed(
                new Violation(self::KEYWORD, 'The provided value is not a collection')
            );
        }

        $filterInvalidResults = function (array $results, mixed $item) {
            $result = $this->rule->validate($item);

            if ($result->isFailed()) {
                $results[] = $result;
            }

            return $results;
        };

        $results = array_reduce($value, $filterInvalidResults, []);

        if (count($results) > 0) {
            return ValidatableResult::failed(
                new Violation(self::KEYWORD, 'The provided value contains invalid items')
            );
        }

        return ValidatableResult::succeeded();
    }
}
