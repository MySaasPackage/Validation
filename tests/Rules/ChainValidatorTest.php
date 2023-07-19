<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class ChainValidatorTest extends TestCase
{
    public function testSuccessfully(): void
    {
        $chain = ChainValidator::create()
            ->required()
            ->length(8, 20);

        $result = $chain->validate('alef@gmail.com');
        $this->assertTrue($result->isSucceeded());
    }

    public function testCollectionSuccessfully(): void
    {
        $chain = ChainValidator::create()
            ->collection();

        $result = $chain->validate(['alef@gmail.com']);
        $this->assertTrue($result->isSucceeded());
    }

    public function testCollectionOfSuccessfully(): void
    {
        $chain = ChainValidator::create()
            ->collectionOf(ChainValidator::create()->email());

        $result = $chain->validate(['alef@gmail.com', 'sara@gmail.com']);
        $this->assertTrue($result->isSucceeded());
    }

    public function testEmailSuccessfully(): void
    {
        $chain = ChainValidator::create()
            ->required()
            ->email();

        $result = $chain->validate('alef@gmail.com');
        $this->assertTrue($result->isSucceeded());
    }

    public function testPhoneSuccessfully(): void
    {
        $chain = ChainValidator::create()
            ->required()
            ->phone();

        $result = $chain->validate('+525592345678');
        $this->assertTrue($result->isSucceeded());
    }
}
