<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class IsUuidTest extends TestCase
{
    protected IsUuid $rule;

    public function setup(): void
    {
        $this->rule = new IsUuid();
    }

    public function testSuccessful(): void
    {
        $violationOrNull = $this->rule->validate('00000001-0000-0000-0000-000000000001');
        $this->assertSame(null, $violationOrNull);
    }

    public function testFailed(): void
    {
        $violationOrNull = $this->rule->validate('invalid-uuid');
        $this->assertNotSame(null, $violationOrNull);
        $this->assertEquals(IsUuid::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value must be a valid uuid', $violationOrNull->message);
    }
}
