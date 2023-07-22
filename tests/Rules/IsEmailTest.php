<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class IsEmailTest extends TestCase
{
    protected IsEmail $rule;

    public function setup(): void
    {
        $this->rule = new IsEmail();
    }

    public function testSuccessful(): void
    {
        $violationOrNull = $this->rule->validate('valid@email.com');
        $this->assertSame(null, $violationOrNull);
    }

    public function testFailed(): void
    {
        $violationOrNull = $this->rule->validate('invalid@email');
        $this->assertNotSame(null, $violationOrNull);
        $this->assertEquals(IsEmail::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value must be a valid email', $violationOrNull->message);
    }
}
