<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validator;
use PHPUnit\Framework\TestCase;

final class SchemaTypeTest extends TestCase
{
    public function testSchemaTypeRuleSuccessfully(): void
    {
        $rule = Validator::create()->schema([
            'name' => Validator::create()->required()->string(),
            'age' => Validator::create()->required()->integer(),
            'email' => Validator::create()->required()->email(),
        ]);

        $result = $rule->validate([
            'name' => 'John Doe',
            'age' => 30,
            'email' => 'alef@gmail.com',
        ]);
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testNestedSchemaTypeRuleSuccessfully(): void
    {
        $rule = Validator::create()->schema([
            'name' => Validator::create()->required()->string(),
            'age' => Validator::create()->required()->integer(),
            'email' => Validator::create()->required()->email(),
            'address' => Validator::create()->schema([
                'city' => Validator::create()->required()->string(),
                'country' => Validator::create()->required()->string(),
            ]),
        ]);

        $result = $rule->validate([
            'name' => 'John Doe',
            'age' => 30,
            'email' => 'alef@gmail.com',
            'address' => [
                'city' => 'Tehran',
                'country' => 'Iran',
            ],
        ]);

        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testNestedSchemaTypeRuleWithCollectionSuccessfully(): void
    {
        $rule = Validator::create()->schema([
            'name' => Validator::create()->required()->string(),
            'age' => Validator::create()->required()->integer(),
            'email' => Validator::create()->required()->email(),
            'address' => Validator::create()->collection(
                Validator::create()->schema([
                    'city' => Validator::create()->required()->string(),
                    'country' => Validator::create()->required()->string(),
                ])
            ),
        ]);

        $result = $rule->validate([
            'name' => 'John Doe',
            'age' => 30,
            'email' => 'alef@gmail.com',
            'address' => [
                [
                    'city' => 'Tehran',
                    'country' => 'Iran',
                ],
            ],
        ]);

        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testNestedSchemaTypeRuleWithCollectionFailure(): void
    {
        $rule = Validator::create()->schema([
            'name' => Validator::create()->required()->string(),
            'age' => Validator::create()->required()->integer(),
            'email' => Validator::create()->required()->email(),
            'address' => Validator::create()->collection(
                Validator::create()->schema([
                    'city' => Validator::create()->required()->string(),
                    'country' => Validator::create()->required()->string(),
                ])
            ),
        ]);

        $result = $rule->validate([
            'name' => 'John Doe',
            'age' => 30,
            'email' => 'alef@gmail.com',
            'address' => [
                'city' => 'Tehran',
                'country' => 'Iran',
            ],
        ]);

        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
    }

    public function testSchemaTypeRuleWithInvalidInput(): void
    {
        $rule = Validator::create()->schema([
            'name' => Validator::create()->required()->string(),
            'age' => Validator::create()->required()->integer(),
            'email' => Validator::create()->required()->email(),
        ]);

        $result = $rule->validate([]);
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
        $rule = Validator::create()->schema([
            'name' => Validator::create()->required()->string(),
            'age' => Validator::create()->required()->integer(),
            'email' => Validator::create()->required()->email(),
        ]);

        $result = $rule->validate([
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
        $rule = Validator::create()->schema([
            'name' => Validator::create()->required()->string(),
            'age' => Validator::create()->required()->integer(),
            'email' => Validator::create()->required()->email(),
        ]);

        $result = $rule->validate([
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
