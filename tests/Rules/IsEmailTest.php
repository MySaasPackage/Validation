<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class IsEmailTest extends TestCase
{
    protected IsEmail $rule;

    public function setup(): void
    {
        $this->rule = new IsEmail();
    }

    public function testEmailTypeRuleSuccessfully(): void
    {
        $result = $this->rule->validate('valid@email.com');
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testStringTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate('invalid@email');
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $violation = $result->getViolation();
        $this->assertEquals(IsEmail::KEYWORD, $violation->keyword);
        $this->assertequals('The provided value is not a email', $violation->message);
    }
}
