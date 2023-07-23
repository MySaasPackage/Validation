<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class CountTest extends TestCase
{
    protected Count $rule;

    public function setup(): void
    {
        $this->rule = new Count(2);
    }

    public function testSuccessful(): void
    {
        $violationOrNull = $this->rule->validate([1, 2]);
        $this->assertSame(null, $violationOrNull);
    }

    public function testFailed(): void
    {
        $violationOrNull = $this->rule->validate([]);
        $this->assertNotSame(null, $violationOrNull);
        $this->assertEquals(Count::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value does not have exactly 2 elements', $violationOrNull->message);
    }
}
