<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use InvalidArgumentException;
use MySaasPackage\Validation\RuleResult;
use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;

class MinLength implements Validatable
{
    public const KEYWORD = 'min.length.mismatch';

    public function __construct(
        protected string|int $minLength,
    ) {
        if (!is_numeric($minLength)) {
            throw new InvalidArgumentException('MinLength param must be a number');
        }

        $this->minLength = (int) $minLength;
    }

    public function validate(mixed $value): RuleResult
    {
        if (is_string($value) && strlen($value) >= $this->minLength) {
            return RuleResult::succeeded();
        }

        return RuleResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: MessageFormatter::format('The value must be at least {minLength} characters long', [
                    'minLength' => $this->minLength,
                ]),
            )
        );
    }
}
