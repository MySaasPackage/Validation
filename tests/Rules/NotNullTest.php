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

    public function testNotNullRuleSuccessfully(): void
    {
        $result = $this->rule->validate('foo');
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testStringTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate();
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $violation = $result->getViolation();
        $this->assertEquals(NotNull::KEYWORD, $violation->keyword);
        $this->assertequals('The provided value cannot be null', $violation->message);
    }
}
