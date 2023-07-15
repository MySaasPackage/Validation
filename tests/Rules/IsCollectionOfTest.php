<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class IsCollectionOfTest extends TestCase
{
    protected IsCollectionOf $rule;

    public function setup(): void
    {
        $this->rule = new IsCollectionOf(new IsEmail());
    }

    public function testSuccessfully(): void
    {
        $result = $this->rule->validate(['alef@gmail.com', 'alef@eeclesi.com']);
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testFailedWithString(): void
    {
        $result = $this->rule->validate('alef@gmail.com');
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $violation = $result->getViolation();
        $this->assertEquals(IsCollectionOf::KEYWORD, $violation->keyword);
        $this->assertequals('The provided value is not a collection', $violation->message);
    }

    public function testFailedWithNoEmails(): void
    {
        $result = $this->rule->validate(['alef@gmail.com', 'invalid@gmail']);
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $violation = $result->getViolation();
        $this->assertEquals(IsCollectionOf::KEYWORD, $violation->keyword);
        $this->assertequals('The provided value contains invalid items', $violation->message);
        $this->assertEquals(IsEmail::KEYWORD, $violation->getChildren()->keyword);
        $this->assertEquals('The provided value is not a email', $violation->getChildren()->message);
    }
}
