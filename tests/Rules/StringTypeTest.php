<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class StringTypeTest extends TestCase
{
    protected StringType $requiredRule;

    public function setup(): void
    {
        $this->requiredRule = new StringType();
    }

    public function testStringTypeRuleSuccessfully(): void
    {
        $result = $this->requiredRule->validate('string');
        $this->assertTrue($result->isValid());
        $this->assertFalse($result->isNotValid());
    }

    public function testStringTypeRuleWithInvalidInput(): void
    {
        $result = $this->requiredRule->validate(1);
        $this->assertFalse($result->isValid());
        $this->assertTrue($result->isNotValid());
        $this->assertCount(1, $result->getViolations());
        [$violation] = $result->getViolations();
        $this->assertEquals(StringType::KEYWORD, $violation->keyword);
        $this->assertEquals(1, $violation->args);
        $this->assertEquals('The value must be a string, got integer', $violation->message);
    }
}
