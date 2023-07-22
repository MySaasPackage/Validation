<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class MinLengthTest extends TestCase
{
    protected MinLength $rule;

    public function setup(): void
    {
        $this->rule = new MinLength(10);
    }

    public function testSuccessful(): void
    {
        $violationOrNull = $this->rule->validate('+52559999999');
        $this->assertSame(null, $violationOrNull);
    }

    public function testFailed(): void
    {
        $violationOrNull = $this->rule->validate('invalid');
        $this->assertNotSame(null, $violationOrNull);
        $this->assertEquals(MinLength::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value must be at least 10 characters', $violationOrNull->message);
    }
}
