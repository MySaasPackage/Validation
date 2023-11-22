<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

enum Gender: string
{
    case FOO = 'foo';
    case BAR = 'bar';
}

final class IsEnumValidTest extends TestCase
{
    protected IsEnumValid $rule;

    public function setup(): void
    {
        $this->rule = new IsEnumValid(Gender::class);
    }

    public function testSuccessful(): void
    {
        $violationOrNull = $this->rule->validate('foo');
        $this->assertSame(null, $violationOrNull);
    }

    public function testFailed(): void
    {
        $violationOrNull = $this->rule->validate('invalid');
        $this->assertNotSame(null, $violationOrNull);
        $this->assertEquals(IsEnumValid::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value is not a valid enum value', $violationOrNull->message);
    }
}
