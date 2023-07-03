<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class StringTypeTest extends TestCase
{
    protected StringType $rule;

    public function setup(): void
    {
        $this->rule = new StringType();
    }

    public function testStringTypeRuleSuccessfully(): void
    {
        $result = $this->rule->validate('string');
        $this->assertTrue($result->isValid());
        $this->assertFalse($result->isNotValid());
    }

    public function testStringTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate(1);
        $this->assertFalse($result->isValid());
        $this->assertTrue($result->isNotValid());
        $this->assertCount(1, $result->getViolations());
        [$violation] = $result->getViolations();
        $this->assertEquals(StringType::KEYWORD, $violation->keyword);
        $this->assertEquals(1, $violation->args);
        $this->assertEquals('The value must be a string, you provide integer', $violation->message);
    }
}
