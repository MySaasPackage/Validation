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

    public function testNotEmptyRuleSuccessfully(): void
    {
        $result = $this->rule->validate('valid text');
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testStringTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate('');
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $violation = $result->getViolation();
        $this->assertEquals(NotEmpty::KEYWORD, $violation->keyword);
        $this->assertequals('The provided value cannot be empty', $violation->message);
    }
}
