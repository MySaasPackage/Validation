<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\RuleValidationResult;
use MySaasPackage\Validation\Utils\MessageFormatter;
use MySaasPackage\Validation\Violation;

class EmailType
{
    public const REGEX = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,5}$/';

    public const KEYWORD = 'email.type.mismatch';

    public function validate(mixed $value): RuleValidationResult
    {
        if ((bool) preg_match(self::REGEX, (string) $value)) {
            return RuleValidationResult::ok();
        }

        return RuleValidationResult::failed(
            new Violation(
                keyword: self::KEYWORD,
                args: $value,
                message: MessageFormatter::format('The value provided must be a valid string, you provide "{value}"', ['value' => $value])
            )
        );
    }
}
