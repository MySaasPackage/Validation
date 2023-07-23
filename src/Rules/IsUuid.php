<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\SimpleViolation;

use function is_string;
use function preg_match;
use function str_replace;

class IsUuid implements Validatable
{
    public const REGEX = '\A[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}\z';

    public const NIL = '00000000-0000-0000-0000-000000000000';

    public const KEYWORD = 'uuid.mismatch';

    public function validate(mixed $value): Violation|null
    {
        if (!is_string($value)) {
            return new SimpleViolation(
                keyword: self::KEYWORD,
                message: 'The provided value must be a valid uuid'
            );
        }

        $uuid = str_replace(['urn:', 'uuid:', 'URN:', 'UUID:', '{', '}'], '', $value);

        if (self::NIL === $uuid || (bool) preg_match('/'.self::REGEX.'/Dms', (string) $uuid)) {
            return null;
        }

        return new SimpleViolation(
            keyword: self::KEYWORD,
            message: 'The provided value must be a valid uuid'
        );
    }
}
