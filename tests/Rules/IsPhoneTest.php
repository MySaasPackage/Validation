<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class IsPhoneTest extends TestCase
{
    protected IsPhone $rule;

    public function setup(): void
    {
        $this->rule = new IsPhone();
    }

    public function testPhoneTypeRuleSuccessfully(): void
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
        $this->assertEquals(IsPhone::KEYWORD, $violation->keyword);
        $this->assertequals('The provided value is not a phone', $violation->message);
    }
}
