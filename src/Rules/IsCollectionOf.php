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
            return ValidatableResult::failed(new Violation(self::KEYWORD, 'The provided value is not a collection'));
        }

        $violation = new Violation(self::KEYWORD, 'The provided value contains invalid items');

        foreach ($value as $key => $item) {
            $result = $this->rule->validate($item);

            if ($result->isSucceeded()) {
                continue;
            }

            $violation->addChild($result->getViolation()->withPath(sprintf('[%s]', $key)));
        }

        if ($violation->hasChildren()) {
            return ValidatableResult::failed($violation);
        }

        return ValidatableResult::succeeded();
    }
}
