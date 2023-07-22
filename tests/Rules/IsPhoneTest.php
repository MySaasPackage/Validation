<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class IsPhoneTest extends TestCase
{
    protected IsPhone $rule;

    public function setup(): void
    {
        $this->rule = new IsPhone();
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
        $this->assertEquals(IsPhone::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value must be a valid phone', $violationOrNull->message);
    }
}
