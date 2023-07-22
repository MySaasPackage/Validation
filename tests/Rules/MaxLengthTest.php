<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class MaxLengthTest extends TestCase
{
    protected MaxLength $rule;

    public function setup(): void
    {
        $this->rule = new MaxLength(10);
    }

    public function testSuccessful(): void
    {
        $violationOrNull = $this->rule->validate('9999999');
        $this->assertSame(null, $violationOrNull);
    }

    public function testFailed(): void
    {
        $violationOrNull = $this->rule->validate('+525599999999');
        $this->assertNotSame(null, $violationOrNull);
        $this->assertEquals(MaxLength::KEYWORD, $violationOrNull->keyword);
        $this->assertequals('The provided value must be less than 10 characters', $violationOrNull->message);
    }
}
