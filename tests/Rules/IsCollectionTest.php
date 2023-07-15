<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class IsCollectionTest extends TestCase
{
    protected IsCollection $rule;

    public function setup(): void
    {
        $this->rule = new IsCollection();
    }

    public function testCollectionTypeRuleSuccessfully(): void
    {
        $result = $this->rule->validate(['alef@gmail.com', 'alef@eeclesi.com']);
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testCollectionTypeRuleFailed(): void
    {
        $result = $this->rule->validate('alef@gmail.com');
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $violation = $result->getViolation();
        $this->assertEquals(IsCollection::KEYWORD, $violation->keyword);
        $this->assertequals('The provided value is not a collection', $violation->message);
    }
}
