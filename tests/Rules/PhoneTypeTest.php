<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class PhoneTypeTest extends TestCase
{
    protected PhoneType $rule;

    public function setup(): void
    {
        $this->rule = new PhoneType();
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
        $this->assertCount(1, $result->getViolations());
        [$violation] = $result->getViolations();
        $this->assertEquals(PhoneType::KEYWORD, $violation->keyword);
        $this->assertEquals('invalid', $violation->args);
        $this->assertEquals('The value provided must be a valid phone number', $violation->message);
    }
}
