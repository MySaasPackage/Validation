<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class IsStringTest extends TestCase
{
    protected IsString $rule;

    public function setup(): void
    {
        $this->rule = new IsString();
    }

    public function testSuccessful(): void
    {
        $violationOrNull = $this->rule->validate('string');
        $this->assertSame(null, $violationOrNull);
    }

    public function testFailed(): void
    {
        $violationOrNull = $this->rule->validate(1);
        $this->assertNotSame(null, $violationOrNull);
        $this->assertEquals(IsString::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value must be a string', $violationOrNull->message);
    }
}
