<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class MinLengthTest extends TestCase
{
    protected MinLength $rule;

    public function setup(): void
    {
        $this->rule = new MinLength(10);
    }

    public function testMinLengthRuleSuccessfully(): void
    {
        $result = $this->rule->validate('+52559999999');
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testStringTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate('invalid');
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $violation = $result->getViolation();
        $this->assertEquals(MinLength::KEYWORD, $violation->keyword);
        $this->assertequals('The value must be at least 10 characters', $violation->message);
    }
}
