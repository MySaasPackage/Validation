<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class IsIntegerTest extends TestCase
{
    protected IsInteger $rule;

    public function setup(): void
    {
        $this->rule = new IsInteger();
    }

    public function testIntegerTypeRuleSuccessfully(): void
    {
        $result = $this->rule->validate(8);
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testIntegerTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate('8');
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $violation = $result->getViolation();
        $this->assertEquals(IsInteger::KEYWORD, $violation->keyword);
        $this->assertequals('The provided value is not an integer', $violation->message);
    }
}
