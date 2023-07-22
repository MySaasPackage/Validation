<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class NotEmptyTest extends TestCase
{
    protected NotEmpty $rule;

    public function setup(): void
    {
        $this->rule = new NotEmpty();
    }

    public function testSuccessful(): void
    {
        $violationOrNull = $this->rule->validate('valid text');
        $this->assertSame(null, $violationOrNull);
    }

    public function testFailed(): void
    {
        $violationOrNull = $this->rule->validate('');
        $this->assertNotSame(null, $violationOrNull);
        $this->assertEquals(NotEmpty::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value cannot be empty', $violationOrNull->message);
    }
}
