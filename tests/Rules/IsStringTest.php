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

    public function testStringTypeRuleSuccessfully(): void
    {
        $result = $this->rule->validate('string');
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testStringTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate(1);
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $violation = $result->getViolation();
        $this->assertEquals(IsString::KEYWORD, $violation->keyword);
        $this->assertequals('The provided value is not a string', $violation->message);
    }
}
