<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class CollectionTypeTest extends TestCase
{
    protected CollectionType $rule;

    public function setup(): void
    {
        $this->rule = new CollectionType(new EmailType());
    }

    public function testCollectionTypeRuleSuccessfully(): void
    {
        $result = $this->rule->validate(['alef@gmail.com', 'alef@eeclesi.com']);
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testCollectionTypeRuleFailed(): void
    {
        $result = $this->rule->validate(['alef@gmail.com', 'invalid@email']);
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        [$violation] = $result->getViolations();
        $this->assertEquals(EmailType::KEYWORD, $violation->keyword);
        $this->assertEquals('invalid@email', $violation->args);
        $this->assertEquals('The value provided must be a valid email', $violation->message);
    }
}
