<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use PHPUnit\Framework\TestCase;

final class ChainedRuleTest extends TestCase
{
    public function testRuleChainSuccessfully(): void
    {
        $email = ChainedRule::create()->string()->email();
        $this->assertTrue($email->validate('alef@gmail.com')->isSucceeded());
        $this->assertFalse($email->validate('alef')->isSucceeded());

        $phone = ChainedRule::create()->string()->phone();
        $this->assertTrue($phone->validate('+525599999999')->isSucceeded());
        $this->assertFalse($phone->validate('5599999999')->isSucceeded());

        $password = ChainedRule::create()->string()->length(8, 16);
        $this->assertTrue($password->validate('myscretpassword')->isSucceeded());
        $this->assertFalse($password->validate('week')->isSucceeded());
        $this->assertFalse($password->validate('superlargpassword')->isSucceeded());
    }
}
