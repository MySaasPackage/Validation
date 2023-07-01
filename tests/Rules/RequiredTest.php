<?php

declare(strict_types=1);

namespace Eclesi\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class RequiredTest extends TestCase
{
    protected Required $requiredRule;

    public function setup(): void
    {
        $this->requiredRule = new Required();
    }

    public function testRequiredRuleSuccessfully(): void
    {
        $result = $this->requiredRule->validate('valid text');
        $this->assertTrue($result->isValid());
        $this->assertFalse($result->isNotValid());
    }

    public function testStringTypeRuleWithInvalidInput(): void
    {
        $result = $this->requiredRule->validate();
        $this->assertFalse($result->isValid());
        $this->assertTrue($result->isNotValid());
        $this->assertCount(1, $result->getViolations());
        [$violation] = $result->getViolations();
        $this->assertEquals(Required::KEYWORD, $violation->keyword);
        $this->assertEquals(null, $violation->args);
        $this->assertEquals('The value is required', $violation->message);
    }
}
