<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class LengthTest extends TestCase
{
    protected Length $rule;

    public function setup(): void
    {
        $this->rule = new Length(new MinLength(7), new MaxLength(10));
    }

    public function testLengthRuleSuccessfully(): void
    {
        $result = $this->rule->validate('99999999');
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testStringTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate('+525599999999');
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $this->assertCount(1, $result->getViolations());
        [$violation] = $result->getViolations();
        $this->assertEquals(MaxLength::KEYWORD, $violation->keyword);
        $this->assertEquals('+525599999999', $violation->args);
        $this->assertEquals('The value must be less than 10 characters', $violation->message);

        $result = $this->rule->validate('+52559');
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $this->assertCount(1, $result->getViolations());
        [$violation] = $result->getViolations();
        $this->assertEquals(MinLength::KEYWORD, $violation->keyword);
        $this->assertEquals('+52559', $violation->args);
        $this->assertEquals('The value must be at least 7 characters long', $violation->message);
    }
}
