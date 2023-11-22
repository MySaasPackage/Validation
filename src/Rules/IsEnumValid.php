<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\SimpleViolation;

class IsEnumValid implements Validatable
{
    public const KEYWORD = 'enum.mismatch';

    public function __construct(
        protected readonly string $enum,
    ) {
    }

    public function validate(mixed $value = null): Violation|null
    {
        if (!enum_exists($this->enum)) {
            return new SimpleViolation(
                self::KEYWORD,
                message: 'The provided enum does not exist',
            );
        }

        $values = array_map(fn ($value) => $value->value, $this->enum::cases());

        if (in_array($value, $values, true)) {
            return null;
        }

        return new SimpleViolation(
            self::KEYWORD,
            message: 'The provided value is not a valid enum value',
        );
    }
}
