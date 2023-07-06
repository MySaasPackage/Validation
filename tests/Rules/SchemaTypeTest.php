<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\ChainedRule;
use PHPUnit\Framework\TestCase;

final class SchemaTypeTest extends TestCase
{
    protected SchemaType $rule;

    public function setup(): void
    {
        $this->rule = new SchemaType([
            'name' => ChainedRule::create()->required()->string(),
            'age' => ChainedRule::create()->required()->integer(),
            'email' => ChainedRule::create()->required()->email(),
        ]);
    }

    public function testSchemaTypeRuleSuccessfully(): void
    {
        $result = $this->rule->validate([
            'name' => 'John Doe',
            'age' => 30,
            'email' => 'alef@gmail.com',
        ]);
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testSchemaTypeRuleWithInvalidInput(): void
    {
        $result = $this->rule->validate([]);
        [
            'name' => [
                ['keyword' => $nameRequiredKeyword],
                ['keyword' => $nameStringKeyword],
        ],
        'age' => [
            ['keyword' => $ageRequiredKeyword],
            ['keyword' => $ageIntegerKeyword],
        ],
        'email' => [
            ['keyword' => $emailRequiredKeyword],
            ['keyword' => $emailEmailKeyword],
        ]
        ] = $result->__toArray();

        $this->assertEquals(Required::KEYWORD, $nameRequiredKeyword);
        $this->assertEquals(StringType::KEYWORD, $nameStringKeyword);

        $this->assertEquals(Required::KEYWORD, $ageRequiredKeyword);
        $this->assertEquals(IntegerType::KEYWORD, $ageIntegerKeyword);

        $this->assertEquals(Required::KEYWORD, $emailRequiredKeyword);
        $this->assertEquals(EmailType::KEYWORD, $emailEmailKeyword);

        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
    }

    public function testSchemaTypeRuleWithInvalidEmail(): void
    {
        $result = $this->rule->validate([
            'name' => 'John Doe',
            'age' => 30,
            'email' => 'invalid',
        ]);

        ['email' => [['keyword' => $keyword]]] = $result->__toArray();
        $this->assertEquals(EmailType::KEYWORD, $keyword);

        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
    }

    public function testSchemaTypeRuleWithInvalidAge(): void
    {
        $result = $this->rule->validate([
            'name' => 'John Doe',
            'age' => '30',
            'email' => 'alef@gmail.com',
        ]);

        ['age' => [['keyword' => $keyword]]] = $result->__toArray();
        $this->assertEquals(IntegerType::KEYWORD, $keyword);

        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
    }
}
