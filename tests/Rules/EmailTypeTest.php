<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class EmailTypeTest extends TestCase
{
    protected EmailType $rule;

    public function setup(): void
    {
        $this->rule = new EmailType();
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
        $this->assertCount(1, $result->getViolations());
        [$violation] = $result->getViolations();
        $this->assertEquals(EmailType::KEYWORD, $violation->keyword);
        $this->assertEquals('invalid@email', $violation->args);
        $this->assertEquals('The value provided must be a valid email', $violation->message);
    }
}
