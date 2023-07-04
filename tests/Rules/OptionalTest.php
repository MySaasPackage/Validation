<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class OptionalTest extends TestCase
{
    protected Optional $rule;

    public function setup(): void
    {
        $this->rule = new Optional();
    }

    public function testOptionalRuleSuccessfully(): void
    {
        $result = $this->rule->validate();
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());

        $result = $this->rule->validate('foo');
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }
}
