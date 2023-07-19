<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class IsCollectionOf implements Validatable
{
    public const KEYWORD = 'collectionOf.mismatch';

    public function __construct(
        protected readonly Validatable $rule
    ) {
    }

    public function validate(mixed $value): RuleResult
    {
        if (false === is_array($value)) {
            return RuleResult::failed(
                new Violation(
                    self::KEYWORD,
                    'The provided value is not a collection',
                )
            );
        }

        $violation = new Violation(
            self::KEYWORD,
            'The provided value contains invalid items'
        );

        foreach ($value as $item) {
            $result = $this->rule->validate($item);

            if ($result->isSucceeded()) {
                continue;
            }

            $violation->addChild($result->getViolation());
        }

        if ($violation->hasChildren()) {
            return RuleResult::failed($violation);
        }

        return RuleResult::succeeded();
    }
}
