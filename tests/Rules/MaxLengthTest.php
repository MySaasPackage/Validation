<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class MaxLengthTest extends TestCase
{
    protected MaxLength $rule;

    public function setup(): void
    {
        $this->rule = new MaxLength(10);
    }

    public function testMaxLengthRuleSuccessfully(): void
    {
        $result = $this->rule->validate('9999999');
        $this->assertTrue($result->isValid());
        $this->assertFalse($result->isNotValid());
    }

    public function testStringTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate('+525599999999');
        $this->assertFalse($result->isValid());
        $this->assertTrue($result->isNotValid());
        $this->assertCount(1, $result->getViolations());
        [$violation] = $result->getViolations();
        $this->assertEquals(MaxLength::KEYWORD, $violation->keyword);
        $this->assertEquals('+525599999999', $violation->args);
        $this->assertEquals('The value must be less than 10 characters', $violation->message);
    }
}
