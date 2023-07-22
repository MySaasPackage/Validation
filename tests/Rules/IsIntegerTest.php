<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class IsIntegerTest extends TestCase
{
    protected IsInteger $rule;

    public function setup(): void
    {
        $this->rule = new IsInteger();
    }

    public function testSuccessful(): void
    {
        $violationOrNull = $this->rule->validate(8);
        $this->assertSame(null, $violationOrNull);
    }

    public function testFailed(): void
    {
        $violationOrNull = $this->rule->validate('8');
        $this->assertNotSame(null, $violationOrNull);
        $this->assertEquals(IsInteger::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value must be an integer', $violationOrNull->message);
    }
}
