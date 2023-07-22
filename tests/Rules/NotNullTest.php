<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class NotNullTest extends TestCase
{
    protected NotNull $rule;

    public function setup(): void
    {
        $this->rule = new NotNull();
    }

    public function testSuccessful(): void
    {
        $violationOrNull = $this->rule->validate('foo');
        $this->assertSame(null, $violationOrNull);
    }

    public function testFailed(): void
    {
        $violationOrNull = $this->rule->validate();
        $this->assertNotSame(null, $violationOrNull);
        $this->assertEquals(NotNull::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value cannot be null', $violationOrNull->message);
    }
}
