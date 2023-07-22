<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class RequiredTest extends TestCase
{
    protected Required $rule;

    public function setup(): void
    {
        $this->rule = new Required();
    }

    public function testSuccessful(): void
    {
        $violationOrNull = $this->rule->validate('valid text');
        $this->assertSame(null, $violationOrNull);
    }

    public function testFailed(): void
    {
        $violationOrNull = $this->rule->validate();
        $this->assertNotSame(null, $violationOrNull);
        $this->assertEquals(Required::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value is required', $violationOrNull->message);
    }
}
