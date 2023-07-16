<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class RequiredTest extends TestCase
{
    protected Required $rule;

    public function setup(): void
    {
        $this->rule = new Required();
    }

    public function testRequiredRuleSuccessfully(): void
    {
        $result = $this->rule->validate('valid text');
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testStringTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate();
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
    }
}
