<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class IntegerTypeTest extends TestCase
{
    protected IntegerType $rule;

    public function setup(): void
    {
        $this->rule = new IntegerType();
    }

    public function testIntegerTypeRuleSuccessfully(): void
    {
        $result = $this->rule->validate(8);
        $this->assertTrue($result->isValid());
        $this->assertFalse($result->isNotValid());
    }

    public function testIntegerTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate('8');
        $this->assertFalse($result->isValid());
        $this->assertTrue($result->isNotValid());
        $this->assertCount(1, $result->getViolations());
        [$violation] = $result->getViolations();
        $this->assertEquals(IntegerType::KEYWORD, $violation->keyword);
        $this->assertEquals('8', $violation->args);
        $this->assertEquals('The value must be a integer, got string', $violation->message);
    }
}
