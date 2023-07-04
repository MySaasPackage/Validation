<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use PHPUnit\Framework\TestCase;

final class RuleChainTest extends TestCase
{
    public function testRuleChainSuccessfully(): void
    {
        $rule = RuleChain::create()
            ->string()
            ->email();

        $this->assertTrue($rule->validate('alef@gmail.com')->isSucceeded());
    }
}
